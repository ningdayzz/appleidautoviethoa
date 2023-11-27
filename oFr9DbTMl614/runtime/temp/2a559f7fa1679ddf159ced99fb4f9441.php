<?php /*a:4:{s:48:"/www/wwwroot/apple.zenpn.com/view/user/info.html";i:1688815480;s:45:"/www/wwwroot/apple.zenpn.com/view/layout.html";i:1683542048;s:50:"/www/wwwroot/apple.zenpn.com/view/user/header.html";i:1688815274;s:50:"/www/wwwroot/apple.zenpn.com/view/user/footer.html";i:1688813568;}*/ ?>
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

<title>Thông tin cá nhân</title>
<div class="container" style="margin-top: 2%; width: auto;">
<div class="card border-dark">
    <h4 class="card-header bg-primary text-white text-center">Thông tin cá nhân</h4>
    <form action="" method="post" style="margin: 20px;">
        <div class="input-group mb-3">
            <span class="input-group-text" id="username">Tên tài khoản</span>
            <input type="text" class="form-control" name="username"
                   value="<?php echo htmlentities($user->username); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="name">Mật khẩu</span>
            <input type="password" class="form-control" name="password" placeholder="Không sửa đổi vui lòng để trống">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="tg_bot_token">Telegram Bot Token</span>
            <input type="text" class="form-control" name="tg_bot_token" value="<?php echo htmlentities($user->tg_bot_token); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="tg_chat_id">Telegram Chat ID</span>
            <input type="text" class="form-control" name="tg_chat_id" value="<?php echo htmlentities($user->tg_chat_id); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="wx_pusher_id">WeChat Token</span>
            <input type="text" class="form-control" name="wx_pusher_id" value="<?php echo htmlentities($user->wx_pusher_id); ?>">
           
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="webhook">Webhook</span>
            <input type="text" class="form-control" name="webhook" autocomplete="off" value="<?php echo htmlentities($user->webhook); ?>">
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Lưu">
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

