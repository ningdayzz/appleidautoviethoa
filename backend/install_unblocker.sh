RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
PLAIN='\033[0m'
BLUE="\033[36m"

echo "Chọn ngôn ngữ"
echo -e "${YELLOW}Lưu ý rằng ngôn ngữ bạn chọn sẽ ảnh hưởng đến kết quả của chương trình backend${PLAIN}"
echo -e "${BLUE}Tuy nhiên, không hỗ trợ ngôn ngữ nào ngoài tiếng Trung và tiếng Anh trong script cài đặt này${PLAIN}"
echo -e "${BLUE}Tuy nhiên, không hỗ trợ ngôn ngữ nào ngoài tiếng Trung và tiếng Anh trong script cài đặt này${PLAIN}"
echo "1. Tiếng Trung đơn giản (zh_cn)"
echo "2. Tiếng Anh (en_us)"
echo "3. Tiếng Việt (vi_vn)"
read -e language
if [ $language != "1" ] && [ $language != "2" ] && [ $language != "3" ]; then
    echo "Lựa chọn không hợp lệ, thoát | Lựa chọn không hợp lệ, thoát"
    exit;
fi
if [ $language == '1' ]; then
  echo "Quản lý Apple ID của bạn theo cách mới, chương trình tự động phát hiện và mở khóa Apple ID dựa trên các câu hỏi bảo mật"
  echo "Địa chỉ dự án: github.com/pplulee/appleid_auto"
  echo "Nhóm trò chuyện dự án trên Telegram: @appleunblocker"
  echo "==============================================================="
else
  echo "Quản lý Apple ID của bạn theo cách mới, chương trình tự động phát hiện và mở khóa Apple ID dựa trên các câu hỏi bảo mật"
  echo "Địa chỉ dự án: github.com/pplulee/appleid_auto"
  echo "Nhóm trò chuyện dự án trên Telegram: @appleunblocker"
  echo "==============================================================="
fi
if docker >/dev/null 2>&1; then
    echo "Docker đã được cài đặt"
else
    echo "Docker chưa được cài đặt, bắt đầu cài đặt……"
    docker version > /dev/null || curl -fsSL get.docker.com | bash
    systemctl enable docker && systemctl restart docker
    echo "Docker đã được cài đặt"
fi
if [ $language == '1' ]; then
  echo "Bắt đầu cài đặt phần mềm backend Apple_Auto"
  echo "Vui lòng nhập URL API (tên miền frontend, định dạng http[s]://xxx.xxx)"
  read -e api_url
  echo "Vui lòng nhập API Key"
  read -e api_key
  echo "Bạn có muốn bật cập nhật tự động không? (y/n)"
  read -e auto_update
  echo "Vui lòng nhập chu kỳ đồng bộ nhiệm vụ (đơn vị: phút, mặc định 15)"
  read -e sync_time
  if [ "$sync_time" = "" ]; then
      sync_time=15
  fi
  echo "Bạn có muốn triển khai container Docker Selenium không? (y/n)"
  read -e run_webdriver
else
  echo "Bắt đầu cài đặt phần mềm backend Apple_Auto"
  echo "Vui lòng nhập URL API (http://xxx.xxx)"
  read -e api_url
  echo "Vui lòng nhập API Key"
  read -e api_key
  echo "Bạn có muốn bật cập nhật tự động không? (y/n)"
  read -e auto_update
  echo "Vui lòng nhập chu kỳ đồng bộ nhiệm vụ (đơn vị: phút, mặc định 15)"
  read -e sync_time
  if [ "$sync_time" = "" ]; then
      sync_time=15
  fi
  echo "Bạn có muốn triển khai container Docker Selenium không? (y/n)"
  read -e run_webdriver
fi
if [ "$run_webdriver" = "y" ]; then
    echo "Bắt đầu triển khai container Docker Selenium"
    echo "Vui lòng nhập cổng chạy Selenium (mặc định 4444)"
    read -e webdriver_port
    if [ "$webdriver_port" = "" ]; then
        webdriver_port=4444
    fi
    echo "Vui lòng nhập số phiên tối đa của Selenium (mặc định 10)"
    read -e webdriver_max_session
    if [ "$webdriver_max_session" = "" ]; then
        webdriver_max_session=10
    fi
    if docker ps -a --format '{{.Names}}' | grep -q '^webdriver$'; then
    docker rm -f webdriver
    fi
    docker pull selenium/standalone-chrome
    docker run -d --name=webdriver --log-opt max-size=1m --log-opt max-file=1 --shm-size="1g" --restart=always -e SE_NODE_MAX_SESSIONS=$webdriver_max_session -e SE_NODE_OVERRIDE_MAX_SESSIONS=true -e SE_SESSION_RETRY_INTERVAL=1 -e SE_START_VNC=false -p $webdriver_port:4444 selenium/standalone-chrome
    echo "Triển khai xong container Docker Selenium"
fi
enable_auto_update=$([ "$auto_update" == "y" ] && echo True || echo False)
if docker ps -a --format '{{.Names}}' | grep -q '^appleauto$'; then
    docker rm -f appleauto
fi
docker pull sahuidhsu/appleauto_backend
docker run -d --name=appleauto --log-opt max-size=1m --log-opt max-file=2 --restart=always --network=host -e API_URL=$api_url -e API_KEY=$api_key -e SYNC_TIME=$sync_time -e AUTO_UPDATE=$enable_auto_update -e LANG=$language -v /var/run/docker.sock:/var/run/docker.sock sahuidhsu/appleauto_backend
if [ $language = "1" ]; then
  echo "Cài đặt hoàn tất, container đã được khởi động"
  echo "Tên container mặc định: appleauto"
  echo "Cách thao tác:"
  echo "Dừng container: docker stop appleauto"
  echo "Khởi động lại container: docker restart appleauto"
  echo "Kiểm tra log container: docker logs appleauto"
else
  echo "Cài đặt hoàn tất, container đã được khởi động"
  echo "Tên container mặc định: appleauto"
  echo "Cách thao tác:"
  echo "Dừng container: docker stop appleauto"
  echo "Khởi động lại container: docker restart appleauto"
  echo "Kiểm tra log container: docker logs appleauto"
fi
exit 0
