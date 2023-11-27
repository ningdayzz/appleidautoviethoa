<?php /*a:4:{s:50:"/www/wwwroot/apple.zenpn.com/view/admin/index.html";i:1688834744;s:45:"/www/wwwroot/apple.zenpn.com/view/layout.html";i:1683542048;s:51:"/www/wwwroot/apple.zenpn.com/view/admin/header.html";i:1688834624;s:50:"/www/wwwroot/apple.zenpn.com/view/user/footer.html";i:1688813568;}*/ ?>
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

<title>Trung tâm quản trị</title>
<div class="container" style="margin-top: 1%">
    <div class="card border-dark">
        <h2 class="card-header">Trung tâm quản trị</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <b>Lượng người dùng:</b> <?php echo htmlentities($user_count); ?>
            <li class="list-group-item">
                <b>Số tài khoản:</b> <?php echo htmlentities($account_count); ?>
            </li>
            <li class="list-group-item">
                <b>Số trang được chia sẻ:</b> <?php echo htmlentities($share_count); ?>
            </li>
        </ul>
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

