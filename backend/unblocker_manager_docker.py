import argparse
import logging
import threading
import time
from json import loads, dumps

import docker
import schedule
import urllib3
from flask import Flask, request
from requests import post

urllib3.disable_warnings()

prefix = "apple-auto_"
image_name = "loadinghtml/appleid_auto:2.0"
parser = argparse.ArgumentParser(description="")
parser.add_argument("-api_url", help="API URL", required=True)
parser.add_argument("-api_key", help="API key", required=True)
parser.add_argument("-sync_time", help="Thời gian đồng bộ", default="10")
parser.add_argument('-lang', help='Ngôn ngữ', default='1')
parser.add_argument("-auto_update", help="Bật cập nhật tự động ảnh", action='store_true')
args = parser.parse_args()

api_url = args.api_url
api_key = args.api_key
sync_time = int(args.sync_time)
enable_auto_update = args.auto_update

logger = logging.getLogger()
logger.setLevel('INFO')
BASIC_FORMAT = "%(asctime)s [%(levelname)s] %(message)s"
DATE_FORMAT = "%Y-%m-%d %H:%M:%S"
formatter = logging.Formatter(BASIC_FORMAT, DATE_FORMAT)
chlr = logging.StreamHandler()
chlr.setFormatter(formatter)
logger.addHandler(chlr)

if args.lang == '1':
    language = 'zh_cn'
elif args.lang == '2':
    language = 'en_us'
elif args.lang == '3':
    language = 'vi_vn'
else:
    logger.error("Tham số ngôn ngữ không hợp lệ, mặc định sử dụng tiếng Trung")
    language = 'zh_cn'
client = docker.DockerClient(base_url='unix://var/run/docker.sock')


class API:
    def __init__(self):
        self.url = api_url
        self.key = api_key

    def get_backend_api(self):
        try:
            result = loads(
                post(f"{self.url}/api/get_backend_api",
                     verify=False,
                     headers={"key": self.key}).text)
        except Exception as e:
            logger.error("Không thể lấy được API backend")
            logger.error(e)
            return {'enable': False}
        else:
            if result['code'] == 200:
                return result['data']
            else:
                logger.error("Không thể lấy được API backend")
                logger.error(result['msg'])
                return {'enable': False}

    def get_task_list(self):
        try:
            result = loads(
                post(f"{self.url}/api/get_task_list",
                     verify=False,
                     headers={"key": self.key}).text)
        except Exception as e:
            logger.error("Không thể lấy danh sách công việc")
            logger.error(e)
            return False
        else:
            if result['code'] == 200:
                return result['data']
            else:
                logger.error("Không thể lấy danh sách công việc")
                logger.error(result['msg'])
                return None


class local_docker:
    def __init__(self, api):
        self.api = api
        self.local_list = self.get_local_list()

    def deploy_docker(self, id):
        try:
            container_name = f"{prefix}{id}"
            environment = {
                'api_url': self.api.url,
                'api_key': self.api.key,
                'taskid': id,
                'lang': language
            }
            restart_policy = {"Name": "on-failure"}
            log_config = docker.types.LogConfig(max_size="1m", max_file="2")

            # Chạy container
            container = client.containers.run(
                image=image_name,
                name=container_name,
                detach=True,
                environment=environment,
                restart_policy=restart_policy,
                log_config=log_config
            )
        except Exception as e:
            logger.error(f"Không thể triển khai container {id}")
            logger.error(e)
        else:
            logger.info(f"Container {id} triển khai thành công")

    def remove_docker(self, id):
        try:
            container = client.containers.get(f"{prefix}{id}")
            container.remove(force=True)
        except Exception as e:
            logger.error(f"Không thể xóa container {id}")
            logger.error(e)
        else:
            logger.info(f"Container {id} đã xóa thành công")

    def get_local_list(self):
        filters = {
            'name': f'{prefix}*'
        }
        containers = client.containers.list(all=True, filters=filters)
        local_list = []
        for container in containers:
            local_list.append(int(container.name.replace(prefix, "")))
        logger.info(f"Có {len(local_list)} container cục bộ")
        return local_list

    def restart_docker(self, id):
        try:
            if int(id) not in self.local_list:
                return self.sync()
            else:
                container = client.containers.get(f"{prefix}{id}")
                container.restart(timeout=0)
        except Exception as e:
            logger.error(f"Không thể khởi động lại container {id}")
            logger.error(e)
        else:
            logger.info(f"Container {id} đã khởi động lại thành công")

    def get_remote_list(self):
        result_list = self.api.get_task_list()
        if result_list is None or result_list is False:
            logger.info("Không thể lấy danh sách công việc từ đám mây, sử dụng danh sách cục bộ")
            return self.local_list
        else:
            logger.info(f"Lấy được {len(result_list)} công việc từ đám mây")
            return result_list

    def sync(self):
        logger.info("Bắt đầu đồng bộ")
        self.local_list = self.get_local_list()
        remote_list = self.get_remote_list()
        local_set = set(self.local_list)
        remote_set = set(remote_list)

        for id in local_set - remote_set:
            self.remove_docker(id)
            self.local_list.remove(id)

        for id in remote_set - local_set:
            self.deploy_docker(id)
            self.local_list.append(id)
        logger.info("Đồng bộ hoàn tất")

    def clean_local_docker(self):
        logger.info("Bắt đầu làm sạch container cục bộ")
        self.local_list = self.get_local_list()
        for name in self.local_list:
            self.remove_docker(name)
        logger.info("Làm sạch hoàn tất")

    def update(self):
        logger.info("Bắt đầu kiểm tra cập nhật")
        self.local_list = self.get_local_list()
        if len(self.local_list) == 0:
            logger.info("Không có container cần cập nhật")
            return
        current_image_id = client.images.get(f'{image_name}').id
        try:
            client.images.pull(image_name)
            update_image_id = client.images.get(f'{image_name}').id
        except BaseException:
            print(f'Không tìm thấy ảnh từ xa {image_name}')
            exit()
        if current_image_id != update_image_id:
            logger.info("Phát hiện cập nhật ảnh")
            remove_local_docker()
            self.sync()
            logger.info("Cập nhật hoàn tất")
        else:
            logger.info("Không cần cập nhật")


def job():
    global Local
    logger.info("Bắt đầu nhiệm vụ định kỳ")
    Local.sync()


def update():
    global Local
    Local.update()


def start_app(ip, port, token):
    logging.info("Khởi động API backend")
    app = Flask(__name__)

    @app.before_request
    def before_request():
        if request.method != 'POST':
            logging.error("Loại yêu cầu không hợp lệ")
            data = {'status': False, 'msg': 'Loại yêu cầu không hợp lệ'}
            json_data = dumps(data).encode('utf-8')
            return app.response_class(json_data, mimetype='application/json')
        if 'token' not in request.headers:
            logging.error("Yêu cầu không chứa token trong tiêu đề")
            data = {'status': False, 'msg': 'Yêu cầu không chứa token trong tiêu đề'}
            json_data = dumps(data).encode('utf-8')
            return app.response_class(json_data, mimetype='application/json')
        if request.headers['token'] != token:
            logging.error("Mật khẩu không chính xác")
            data = {'status': False, 'msg': 'Token không chính xác'}
            json_data = dumps(data).encode('utf-8')
            return app.response_class(json_data, mimetype='application/json')
        if 'id' not in request.form:
            logging.error("Thiếu id công việc")
            data = {'status': False, 'msg': 'Thiếu id công việc'}
            json_data = dumps(data).encode('utf-8')
            return app.response_class(json_data, mimetype='application/json')

    @app.route('/syncTask', methods=['POST'])
    def resync():
        logging.info("Nhận yêu cầu đồng bộ công việc")
        thread_add_task = threading.Thread(target=Local.sync)
        thread_add_task.start()
        data = {'status': True, 'msg': 'Đồng bộ thành công'}
        json_data = dumps(data).encode('utf-8')
        return app.response_class(json_data, mimetype='application/json')

    @app.route('/addTask', methods=['POST'])
    def add_task():
        logging.info("Nhận yêu cầu thiết lập công việc")
        thread_add_task = threading.Thread(target=Local.deploy_docker, args=(request.form['id'],))
        thread_add_task.start()
        data = {'status': True, 'msg': 'Thiết lập thành công'}
        json_data = dumps(data).encode('utf-8')
        return app.response_class(json_data, mimetype='application/json')

    @app.route('/removeTask', methods=['POST'])
    def remove_task():
        logging.info("Nhận yêu cầu xóa công việc")
        thread_remove_task = threading.Thread(target=Local.remove_docker, args=(request.form['id'],))
        thread_remove_task.start()
        data = {'status': True, 'msg': 'Xóa thành công'}
        json_data = dumps(data).encode('utf-8')
        return app.response_class(json_data, mimetype='application/json')

    @app.route('/restartTask', methods=['POST'])
    def restart_task():
        logging.info("Nhận yêu cầu khởi động lại công việc")
        thread_remove_task = threading.Thread(target=Local.restart_docker, args=(request.form['id'],))
        thread_remove_task.start()
        data = {'status': True, 'msg': 'Khởi động lại thành công'}
        json_data = dumps(data).encode('utf-8')
        return app.response_class(json_data, mimetype='application/json')

    app.run(host=ip, port=port)


def remove_local_docker():
    containers = client.containers.list(all=True, filters={"name": f"{prefix}*"})
    for container in containers:
        container.remove(force=True)


def main():
    logger.info("Khởi động dịch vụ quản lý backend AppleAuto")
    api = API()
    backend_api_result = api.get_backend_api()
    global Local
    Local = local_docker(api)
    logger.info("Kéo ảnh mới nhất")
    client.images.pull(image_name)
    logger.info("Xóa tất cả container cục bộ")
    remove_local_docker()

    if backend_api_result is not None and backend_api_result['enable']:
        thread_app = threading.Thread(target=start_app, daemon=True, args=(
            backend_api_result['listen_ip'], backend_api_result['listen_port'], backend_api_result['token']))
        thread_app.start()
    job()
    logger.info(f"Thời gian đồng bộ là {sync_time} phút")
    schedule.every(sync_time).minutes.do(job)
    if enable_auto_update:
        logger.info("Bật cập nhật tự động")
        schedule.every(8).hours.do(update)
    while True:
        schedule.run_pending()
        time.sleep(1)


if __name__ == '__main__':
    main()
