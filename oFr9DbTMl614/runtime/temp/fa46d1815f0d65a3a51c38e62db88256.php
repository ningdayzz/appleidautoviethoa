<?php /*a:4:{s:54:"/www/wwwroot/autoapple.shop/view/admin/userDetail.html";i:1688836814;s:44:"/www/wwwroot/autoapple.shop/view/layout.html";i:1683542048;s:50:"/www/wwwroot/autoapple.shop/view/admin/header.html";i:1688834624;s:49:"/www/wwwroot/autoapple.shop/view/user/footer.html";i:1688813568;}*/ ?>
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
<header class="navbar navbar-expand-md navbar-dark d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/admin">AppleID Quản lý tự động</a>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/admin">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-house"></i>
                        </span>
                        <span class="nav-link-title">
                            Trang chủ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/user">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="nav-link-title">
                            Quản lý người dùng
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/account">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="nav-link-title">
                            Quản lý tài khoản
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/share">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-share-from-square"></i>
                        </span>
                        <span class="nav-link-title">
                            Chia sẻ quản lý trang
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/proxy">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-earth-asia"></i>
                        </span>
                        <span class="nav-link-title">
                            Quản lý nhóm đại lý
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/record">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-table"></i>
                        </span>
                        <span class="nav-link-title">
                            Hồ sơ nhiệm vụ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <i class="fas fa-gear"></i>
                    </span>
                        <span class="nav-link-title">
                        Bảng điều khiển người dùng
                    </span>
                    </a>
                </li>
            </ul>
        </div>
        <a class="btn btn-danger order-md-last" href="/user/logout">Đăng xuất</a>
    </div>
</header>

<div class="container" style="margin-top: 2%; width: auto;">
<div class="card border">
    <h2 class="card-header bg-primary text-white text-center">Người dùng biên tập</h2>
    <form action="" method="post" style="margin: 20px;">
        <div class="input-group mb-3">
            <span class="input-group-text" id="id">Tài khoản</span>
            <input type="text" class="form-control" name="username" required autocomplete="off"
                   value="<?php echo htmlentities($user->username); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="password">Mật khẩu</span>
            <input type="password" class="form-control" name="password" placeholder="Không sửa đổi vui lòng để trống">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="tg_bot_token">Telegram Bot Token</span>
            <input type="text" class="form-control" name="tg_bot_token" autocomplete="off" value="<?php echo htmlentities($user->tg_bot_token); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="tg_chat_id">Telegram Chat ID</span>
            <input type="text" class="form-control" name="tg_chat_id" autocomplete="off" value="<?php echo htmlentities($user->tg_chat_id); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="wx_pusher_id">Mã thông báo WeChat pushplus</span>
            <input type="text" class="form-control" name="wx_pusher_id" autocomplete="off" value="<?php echo htmlentities($user->wx_pusher_id); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="webhook">Webhook</span>
            <input type="text" class="form-control" name="webhook" autocomplete="off" value="<?php echo htmlentities($user->webhook); ?>">
        </div>
        <div class="form-check form-switch">
            Người quản lý<input class="form-check-input" type="checkbox"
                               name="is_admin" <?php echo !empty($user->is_admin) ? "checked" : ""; ?>>
        </div>

        <input type="hidden" name="action" value="<?php echo htmlentities($action); ?>">
        <input type="submit" name="submit" class="btn btn-primary btn-block" value="<?php echo $action=="add" ? "Thêm vào" : "Lưu"; ?>">
    </form>
</div>
</div>
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

