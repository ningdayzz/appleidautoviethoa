<?php /*a:4:{s:55:"/www/wwwroot/apple.zenpn.com/view/user/shareDetail.html";i:1683542048;s:45:"/www/wwwroot/apple.zenpn.com/view/layout.html";i:1683542048;s:50:"/www/wwwroot/apple.zenpn.com/view/user/header.html";i:1683542048;s:50:"/www/wwwroot/apple.zenpn.com/view/user/footer.html";i:1683542048;}*/ ?>
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
                            trang chủ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/account">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="nav-link-title">
                            quản lý tài khoản
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
                            Quản lý nhóm đại lý
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/record">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-table"></i>
                        </span>
                        <span class="nav-link-title">
                            hồ sơ nhiệm vụ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/info">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-circle-info"></i>
                        </span>
                        <span class="nav-link-title">
                            thông tin cá nhân
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
                            bảng quản trị
                        </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <a class="btn btn-danger order-md-last" href="/user/logout">Đăng xuất</a>
    </div>
</header>
<div class="container" style="margin-top: 2%; width: auto">
<div class="card border">
    <h2 class="card-header bg-primary text-white text-center"><?php echo $action=="add" ? "thêm trang chia sẻ" : "chỉnh sửa trang chia sẻ"; ?></h2>
    <form action="" method="post" style="margin: 20px;">
        <span class="input-group-text" id="account_list">Vui lòng chọn một tài khoản</span>
        <div class="form-check mb-3">
            <?php foreach($accounts as $id => $username): ?>
            <?php echo htmlentities($username); ?> <input class="form-check-input" type="checkbox" role="switch" name="account_list[]"
                               value="<?php echo htmlentities($id); ?>" <?php echo $checked=in_array($id, $share->account_list)?"checked" : ""; ?>><br>
            <?php endforeach; ?>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">chia sẻ mã</span>
            <input type="text" class="form-control" name="share_link" value="<?php echo htmlentities($share->share_link); ?>" required
                   autocomplete="off">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="password">mật khẩu trang</span>
            <input type="text" class="form-control" name="password" placeholder="Để trống để tắt mật khẩu"
                   autocomplete="off" value="<?php echo htmlentities($share->password); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="remark">Nhận xét</span>
            <input type="text" class="form-control" name="remark" autocomplete="off" value="<?php echo htmlentities($share->remark); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="html">nội dung HTML</span>
            <textarea name="html" style="width: 100%;" rows="10"><?php echo htmlentities($share->html); ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="expire">hết hạn</span>
            <input type="datetime-local" class="form-control" name="expire" value="<?php echo htmlentities($share->expire); ?>">
        </div>
        <div class="alert alert-info" role="alert">
            <div class="d-flex">
                <div>
                    <i class="fas fa-circle-info"></i>
                </div>
                <div>
                    <div class="text-muted">Để trống thời gian hết hạn có nghĩa là nó sẽ không bao giờ hết hạn</div>
                </div>
            </div>
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
     
      </p>
    </div>
  </div>
</div>

