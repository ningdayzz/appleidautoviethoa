<?php /*a:4:{s:55:"/www/wwwroot/autoapple.shop/view/user/unlockRecord.html";i:1688816676;s:44:"/www/wwwroot/autoapple.shop/view/layout.html";i:1683542048;s:49:"/www/wwwroot/autoapple.shop/view/user/header.html";i:1688815274;s:49:"/www/wwwroot/autoapple.shop/view/user/footer.html";i:1688813568;}*/ ?>
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

<title>Hồ sơ nhiệm vụ</title>
<div class="container" style="padding-top:50px;">
    <div class="col-md-12 center-block" style="float: none;">
        <h1>Hồ sơ nhiệm vụ</h1>
        <div class="table-responsive" style="margin-top: 13px;">
            <table class="table table-striped table-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tài khoản</th>
                    <th>Kiểu</th>
                    <th>Tình trạngtrạng</th>
                    <th>Đăng nhập</th>
                    <th>IP</th>
                    <th>Thời gian</th>
                </tr>
                </thead>
                <tbody>
                <?php if($unlockRecords->isEmpty()): ?>
                <tr>
                    <td class="text-center" colspan="7">Không có dữ liệu</td>
                </tr>
                <?php endif; if(is_array($unlockRecords) || $unlockRecords instanceof \think\Collection || $unlockRecords instanceof \think\Paginator): $i = 0; $__LIST__ = $unlockRecords;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$record): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo htmlentities($record['id']); ?></td>
                    <td><?php echo htmlentities($record['username']); ?></td>
                    <td><?php echo htmlentities($record['type']); ?></td>
                    <td><?php echo !empty($record['status']) ? "Thành công" : "Thất bại"; ?></td>
                    <td><?php echo htmlentities($record['message']); ?></td>
                    <td><?php echo htmlentities($record['ip']); ?></td>
                    <td><?php echo htmlentities($record['time']); ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <?php echo $unlockRecords; ?>
        </div>
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

