<?php /*a:4:{s:58:"/www/wwwroot/apple.zenpn.com/view/admin/accountDetail.html";i:1688834354;s:45:"/www/wwwroot/apple.zenpn.com/view/layout.html";i:1683542048;s:51:"/www/wwwroot/apple.zenpn.com/view/admin/header.html";i:1688834624;s:50:"/www/wwwroot/apple.zenpn.com/view/user/footer.html";i:1688813568;}*/ ?>
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
    <h2 class="card-header bg-primary text-white text-center">Chỉnh sửa tài khoản</h2>
    <form action="" method="post" style="margin: 20px;">
        <div class="input-group mb-3">
            <span class="input-group-text" id="id">Tên tài khoản</span>
            <input type="text" class="form-control" name="username" required autocomplete="off"
                   value="<?php echo htmlentities($account->username); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="password">Mật khẩu</span>
            <input type="text" class="form-control" name="password" required autocomplete="off"
                   value="<?php echo htmlentities($account->password); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="remark">Nhận xét</span>
            <input type="text" class="form-control" name="remark" autocomplete="off" value="<?php echo htmlentities($account->remark); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="frontend_remark">Nhận xét đầu cuối</span>
            <input type="text" class="form-control" name="frontend_remark" placeholder="Mô tả tài khoản, hiển thị trên trang chia sẻ"
                   autocomplete="off" value="<?php echo htmlentities($account->frontend_remark); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="dob">Sinh nhật</span>
            <input type="date" class="form-control" name="dob" required
                   autocomplete="off" value="<?php echo htmlentities($account->dob); ?>">
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="question1">Câu hỏi 1</span>
                    <input type="text" class="form-control" name="question1" required autocomplete="off"
                           value="<?php echo htmlentities($account->question1); ?>">
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="answer1">Trả lời 1</span>
                    <input type="text" class="form-control" name="answer1" required autocomplete="off"
                           value="<?php echo htmlentities($account->answer1); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="question2">Câu hỏi 2</span>
                    <input type="text" class="form-control" name="question2" required autocomplete="off"
                           value="<?php echo htmlentities($account->question2); ?>">
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="answer2">Trả lời 2</span>
                    <input type="text" class="form-control" name="answer2" required autocomplete="off"
                           value="<?php echo htmlentities($account->answer2); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="question2">Câu hỏi 3</span>
                    <input type="text" class="form-control" name="question3" required autocomplete="off"
                           value="<?php echo htmlentities($account->question3); ?>">
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="answer2">Trả lời 3</span>
                    <input type="text" class="form-control" name="answer3" required autocomplete="off"
                           value="<?php echo htmlentities($account->answer3); ?>">
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="check_interval">Kiểm tra khoảng thời gian</span>
            <input type="number" class="form-control" name="check_interval" required autocomplete="off"
                   placeholder="Đơn vị: phút" value="<?php echo htmlentities($account->check_interval); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="check_interval">Thông tin</span>
            <input type="text" class="form-control" disabled value="<?php echo htmlentities($account->message); ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="owner">ID chủ sở hữu</span>
            <input type="number" class="form-control" required name="owner" value="<?php echo htmlentities($account->owner); ?>">
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="form-check form-switch">
                        Kiểm tra đúng mật khẩu<input class="form-check-input" type="checkbox"
                                           name="enable_check_password_correct" <?php echo !empty($account->enable_check_password_correct) ? "checked" : ""; ?>>
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-circle-info"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Nếu mật khẩu không chính xác, mật khẩu sẽ được thay đổi tự động</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <div class="form-check form-switch">
                        Xóa thiết bị<input class="form-check-input" type="checkbox"
                                       name="enable_delete_devices" <?php echo !empty($account->enable_delete_devices) ? "checked" : ""; ?>>
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-circle-info"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Tự động xóa thiết bị trên tài khoản</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <div class="form-check form-switch">
                        Tự động thay đổi mật khẩu<input class="form-check-input" type="checkbox"
                                           name="enable_auto_update_password" <?php echo !empty($account->enable_auto_update_password) ? "checked" : ""; ?>>
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-circle-info"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Mật khẩu buộc phải thay đổi mỗi khi một tác vụ được thực thi và mật khẩu có thể được thay đổi thường xuyên.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <div class="form-check form-switch">
                        Người dùng mở khóa khoảng thời gian tối thiểu<input type="number" class="form-control" min="0" name="min_manual_unlock" value="<?php echo htmlentities($account->min_manual_unlock); ?>">
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-circle-info"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Khi API phụ trợ được bật, việc mở khóa tài khoản thủ công được cho phép trên trang chia sẻ. Cài đặt xác định khoảng thời gian tối thiểu giữa các lần mở khóa thủ công. Đặt nó thành 0 có nghĩa là người dùng không được phép mở khóa thủ công.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-check form-switch">
            Kích hoạt tài khoản<input class="form-check-input" type="checkbox"
                               name="enable" <?php echo !empty($account->enable) ? "checked" : ""; ?>>
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

