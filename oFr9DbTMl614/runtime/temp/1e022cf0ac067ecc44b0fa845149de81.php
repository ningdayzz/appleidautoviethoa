<?php /*a:4:{s:48:"/www/wwwroot/autoapple.shop/view/user/share.html";i:1688816356;s:44:"/www/wwwroot/autoapple.shop/view/layout.html";i:1683542048;s:49:"/www/wwwroot/autoapple.shop/view/user/header.html";i:1688815274;s:49:"/www/wwwroot/autoapple.shop/view/user/footer.html";i:1688813568;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link href="/static/css/tabler.min.css" rel="stylesheet">
    <script src="/static/js/tabler.min.js"></script>
    <script src="/static/js/sweetalert2.all.min.js"></script>
    <link href="/static/css/sweetalert2.min.css" rel="stylesheet">
    <script src="/static/js/clipboard.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
</head>
<header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/user">AppleID</a>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/user">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-house"></i>
                        </span>
                        <span class="nav-link-title">
                            Trang chủ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/account">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="nav-link-title">
                            Quản lý tài khoản
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/share">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-share-from-square"></i>
                        </span>
                        <span class="nav-link-title">
                            Chia sẻ quản lý trang
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/proxy">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-earth-asia"></i>
                        </span>
                        <span class="nav-link-title">
                            Quản lý nhóm proxy
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/record">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-table"></i>
                        </span>
                        <span class="nav-link-title">
                            Hồ sơ nhiệm vụ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/info">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-circle-info"></i>
                        </span>
                        <span class="nav-link-title">
                            Thông tin cá nhân
                        </span>
                    </a>
                </li>
                <?php if(isAdmin(session("user_id"))): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-gear"></i>
                        </span>
                            <span class="nav-link-title">
                            Bảng quản trị
                        </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <a class="btn btn-danger order-md-last" href="/user/logout">Đăng xuất</a>
    </div>
</header>

<title>Chia sẻ quản lý trang</title>
<div class="container" style="padding-top:50px;">
    <div class="col-md-12 center-block" style="float: none;">
        <div class="table-responsive">
            <h1>Chia sẻ quản lý trang
            <a class='btn btn-azure' href='/user/share/add'><i class="fas fa-plus"></i>Thêm trang chia sẻ</a>
            </h1>
            <table class="table table-striped table-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nhận xét</th>
                    <th>Số tài khoản</th>
                    <th>Hết hạn</th>
                    <th>vận hành</th>
                </tr>
                <script>
                    var clipboard = new ClipboardJS('.btn');

                    function alert_success() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo',
                            text: 'sao chép thành công',
                            timer: 1000,
                            timerProgressBar: true
                        });
                    }
                </script>
                </thead>
                <tbody>
                <?php if($shares->isEmpty()): ?>
                <tr>
                    <td class="text-center" colspan="5">Không có dữ liệu</td>
                </tr>
                <?php endif; if(is_array($shares) || $shares instanceof \think\Collection || $shares instanceof \think\Paginator): $i = 0; $__LIST__ = $shares;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$share): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo htmlentities($share['id']); ?></td>
                    <td><?php echo htmlentities($share['remark']); ?></td>
                    <td><?php echo htmlentities($count=count(explode(',',$share['account_list']))); ?></td>
                    <td><?php echo $share['expire']==null ? "không bao giờ hết hạn" : htmlentities($share['expire']); ?></td>
                    <td>
                        <a class="btn btn-secondary" href="/user/share/<?php echo htmlentities($share['id']); ?>">Sửa</a>
                        <button class="btn btn-danger delete-button" data-id="<?php echo htmlentities($share['id']); ?>">xóa bỏ</button>
                        <button class="btn btn-success" data-clipboard-text="<?php echo htmlentities($shareURL.$share['share_link']); ?>" onclick="alert_success()">Sao chép đường dẫn</button>
                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <?php echo $shares; ?>
        </div>
    </div>
</div>
<script>
    // 找到所有带有.delete-user类名的按钮
    var deleteButtons = document.querySelectorAll('.delete-button');
    // 遍历所有按钮并为每个按钮添加一个点击事件监听器
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // 获取该按钮的data-id属性，即任务ID
            var Id = button.getAttribute('data-id');

            // 显示SweetAlert2确认弹窗
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa trang chia sẻ này？',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'xác nhận xóa',
                cancelButtonText: 'Hủy bỏ'
            }).then(function (result) {
                // 如果用户点击了“确认”按钮，则向服务器发送DELETE请求
                if (result.value) {
                    // 发送DELETE请求
                    fetch('/user/share/' + Id, {
                        method: 'DELETE'
                    }).then(function (response) {
                        // 处理服务器响应
                        if (response.ok) {
                            // 解析响应数据
                            return response.json();
                        } else {
                            // 如果删除失败，显示SweetAlert2错误提示框
                            throw new Error('HTTP error ' + response.status);
                        }
                    }).then(data => {
                        if (data.status === true) {
                            // 如果删除成功，显示SweetAlert2成功提示框
                            Swal.fire({
                                title: 'xóa thành công！',
                                confirmButtonText: 'OK',
                                icon: 'success'
                            }).then(function (result) {
                                // 如果用户点击了“确定”按钮，则刷新页面
                                if (result.value) {
                                    location.reload();
                                }
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            // 如果删除失败，显示SweetAlert2错误提示框
                            throw new Error(data.msg);
                        }
                    }).catch(error => {
                        // 处理错误
                        Swal.fire({
                            title: error.message,
                            text: error.toString(),
                            icon: 'error'
                        });
                    });
                }
            });
        });
    });
</script>
<style>
.footer {
  bottom: 0;
  width: 100%;
  text-align: center;
}
</style>

<div class="footer footer-transparent">
  <div class="row align-items-center justify-content-center">
    <div class="col-md-6 text-md-right text-center">
      <p class="copyright"><?php echo htmlentities($year=date('Y')); ?> &copy; <a href="https://zenpn.com">ZENPN.COM</a>
      </p>
    </div>
  </div>
</div>

