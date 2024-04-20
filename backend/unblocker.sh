RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
PLAIN='\033[0m'
BLUE="\033[36m"

echo "Vui lòng chọn ngôn ngữ | Please select a language"
echo -e "${YELLOW}Vui lòng lưu ý rằng ngôn ngữ bạn chọn sẽ ảnh hưởng đến đầu ra của chương trình backend${PLAIN}"
echo -e "请注意，你选择的语言将影响后端程序的输出${PLAIN}"
echo -e "${BLUE}Tuy nhiên, kịch bản cài đặt này chỉ hỗ trợ tiếng Trung và tiếng Anh${PLAIN}"
echo "1. Tiếng Trung giản thể (zh_cn)"
echo "2. Tiếng Anh (en_us)"
echo "3. Tiếng Việt (vi_vn)"
read -e language
if [ $language != "1" ] && [ $language != "2" ] && [ $language != "3" ]; then
    echo "Lỗi nhập, thoát | Input error, exit"
    exit;
fi
if [ $language == '1' ]; then
  echo "Quản lý Apple ID của bạn theo một cách mới, một chương trình tự động phát hiện và mở khóa Apple ID dựa trên câu hỏi bảo mật"
  echo "Địa chỉ dự án: github.com/pplulee/appleid_auto"
  echo "Nhóm trò chuyện dự án trên Telegram: @appleunblocker"
  echo "==============================================================="
else
  echo "Manage your Apple ID in a new way, an automated Apple ID detection & unlocking program based on security questions"
  echo "Project address: github.com/pplulee/appleid_auto"
  echo "Project discussion Telegram group: @appleunblocker"
  echo "==============================================================="
fi
if docker >/dev/null 2>&1; then
    echo "Docker đã được cài đặt | Docker is installed"
else
    echo "Docker chưa được cài đặt, bắt đầu cài đặt... | Docker is not installed, start installing..."
    docker version > /dev/null || curl -fsSL get.docker.com | bash
    systemctl enable docker && systemctl restart docker
    echo "Cài đặt Docker hoàn tất | Docker installed"
fi
if [ $language == '1' ]; then
  echo "Bắt đầu cài đặt backend Apple_Auto"
  echo "Vui lòng nhập URL API (Tên miền frontend, định dạng http[s]://xxx.xxx)"
  read -e api_url
  echo "Vui lòng nhập API Key"
  read -e api_key
  echo "Bạn có muốn bật cập nhật tự động không? (y/n)"
  read -e auto_update
  echo "Vui lòng nhập khoảng thời gian đồng bộ nhiệm vụ (đơn vị: phút, mặc định 15)"
  read -e sync_time
  if [ "$sync_time" = "" ]; then
      sync_time=15
  fi
  echo "Bạn có muốn triển khai container Docker Selenium không? (y/n)"
  read -e run_webdriver
else
  echo "Start installing Apple_Auto backend"
  echo "Please enter API URL (http://xxx.xxx)"
  read -e api_url
  echo "Please enter API Key"
  read -e api_key
  echo "Do you want to enable auto update? (y/n)"
  read -e auto_update
  echo "Please enter the task synchronization period (unit: minute, default 15)"
  read -e sync_time
  if [ "$sync_time" = "" ]; then
      sync_time=15
  fi
  echo "Do you want to deploy Selenium Docker container? (y/n)"
  read -e run_webdriver
fi
if [ "$run_webdriver" = "y" ]; then
    echo "Bắt đầu triển khai container Docker Selenium | Start deploying Selenium Docker container"
    echo "Vui lòng nhập cổng chạy Selenium (mặc định 4444) | Please enter Selenium running port (default 4444)"
    read -e webdriver_port
    if [ "$webdriver_port" = "" ]; then
        webdriver_port=4444
    fi
    echo "Vui lòng nhập số phiên tối đa của Selenium (mặc định 10) | Please enter the maximum session number of Selenium (default 10)"
    read -e webdriver_max_session
    if [ "$webdriver_max_session" = "" ]; then
        webdriver_max_session=10
    fi
    if docker ps -a --format '{{.Names}}' | grep -q '^webdriver$'; then
    docker rm -f webdriver
    fi
    docker pull selenium/standalone-chrome
    docker run -d --name=webdriver --log-opt max-size=1m --log-opt max-file=1 --shm-size="1g" --restart=always -e SE_NODE_MAX_SESSIONS=$webdriver_max_session -e SE_NODE_OVERRIDE_MAX_SESSIONS=true -e SE_SESSION_RETRY_INTERVAL=1 -e SE_START_VNC=false -p $webdriver_port:4444 selenium/standalone-chrome
    echo "Container Docker Webdriver triển khai hoàn tất | Webdriver Docker container deployed"
fi
enable_auto_update=$([ "$auto_update" == "y" ] && echo True || echo False)
if docker ps -a --format '{{.Names}}' | grep -q '^appleauto$'; then
    docker rm -f appleauto
fi
docker pull loadinghtml/appleauto_backend
docker run -d --name=appleauto --log-opt max-size=1m --log-opt max-file=2 --restart=always --network=host -e API_URL=$api_url -e API_KEY=$api_key -e SYNC_TIME=$sync_time -e AUTO_UPDATE=$enable_auto_update -e LANG=$language -v /var/run/docker.sock:/var/run/docker.sock loadinghtml/appleauto_backend
if [ $language = "1" ]; then
  echo "Cài đặt hoàn tất, container đã được bật"
  echo "Tên container mặc định: appleauto"
  echo "Cách thức vận hành:"
  echo "Dừng container: docker stop appleauto"
  echo "Khởi động lại container: docker restart appleauto"
  echo "Kiểm tra nhật ký container: docker logs appleauto"
else
  echo "Cài đặt hoàn tất, container đã được bật"
  echo "Tên container mặc định: appleauto"
  echo "Cách thức vận hành:"
  echo "Dừng container: docker stop appleauto"
  echo "Khởi động lại container: docker restart appleauto"
  echo "Kiểm tra trạng thái: docker logs appleauto"
fi
exit 0
