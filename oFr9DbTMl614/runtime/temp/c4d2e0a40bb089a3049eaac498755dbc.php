<?php /*a:2:{s:51:"/www/wwwroot/apple.zenpn.com/view/share/result.html";i:1688836791;s:45:"/www/wwwroot/apple.zenpn.com/view/layout.html";i:1683542048;}*/ ?>
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
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>ID APPLE</title>
</head>
<body>
<script>
    var clipboard = new ClipboardJS('.btn');

    function alert_success() {
        Swal.fire({
            icon: 'success',
            title: 'Thông báo',
            text: 'Sao chép thành công',
            timer: 1000,
            timerProgressBar: true
        });
    }

    function updateCardStyle() {
      var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
      var styleElement = document.createElement('style');

      if (width < 1040) {
        styleElement.innerHTML = '.card { margin-top: 1rem; }';
      } else {
        styleElement.innerHTML = '.card { margin-top: 1rem; margin-left: 35%; width: 30%; }';
      }

      var oldStyleElement = document.getElementById('card-style');
      if (oldStyleElement) {
        oldStyleElement.parentNode.removeChild(oldStyleElement);
      }

      styleElement.id = 'card-style';
      document.getElementsByTagName('head')[0].appendChild(styleElement);
    }
    <?php if(count($accounts) == 1): ?>
    updateCardStyle();
    window.addEventListener('resize', updateCardStyle);
    <?php endif; ?>
</script>

<div class="container">
    <div class="row row-deck" <?php if(count($accounts) == 1): ?> style="align-items: center" <?php endif; ?>>
        <?php if(is_array($accounts) || $accounts instanceof \think\Collection || $accounts instanceof \think\Paginator): $i = 0; $__LIST__ = $accounts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$account): $mod = ($i % 2 );++$i;if(count($accounts) > 1): ?>
        <div class="col-xs-4 col-md-4">
        <?php endif; ?>
                <div class="card shadow-lg" style="margin-top: 1rem;">
                    <div class="card-status-start bg-<?php echo !empty($account->status) ? "green" : "red"; ?>"></div>
                    <div class="card-body">
                        <h3 class="card-title">Thông tin tài khoản</h3>
                        <h3 class="card-text"> Tài khoản: <?php echo htmlentities($account->username); ?></h3>
                        <h3 class="card-text"> Mật khẩu: <?php echo htmlentities($account->password); ?></h3>
                        <?php if($account->frontend_remark!=""): ?>
                            <p class="card-subtitle mb-2 text-muted" style="line-height: 25px"><h3>Nhận xét：<?php echo $account->frontend_remark; ?> </h3></p>
                        <?php endif; ?>
                        <p class="card-subtitle mb-2 text-muted" style="line-height: 25px"><h3>Lần kiểm tra cuối：<?php echo htmlentities($account->last_check); ?> </h3></p>
                        <p class="card-subtitle mb-2 text-muted" style="line-height: 25px"><h3>Tình trạng：
                        <?php if($account->status): ?>
                            <span class="badge bg-green">Bình thường</span>
                        <?php else: ?>
                            <span class="badge bg-red">Không hoạt động</span>
                        <?php endif; ?>
                        </h3> </p>
                        <button id="username_<?php echo htmlentities($account->id); ?>" class="btn btn-primary"
                                data-clipboard-text="<?php echo htmlentities($account->username); ?>"
                                onclick="alert_success()">Sao chép tài khoản
                        </button>
                        <button id="password_<?php echo htmlentities($account->id); ?>" class="btn btn-success"
                                data-clipboard-text="<?php echo htmlentities($account->password); ?>"
                                onclick="alert_success()">Sao chép mật khẩu
                        </button>
                        <?php if($account->min_manual_unlock!=0 && env('backend.enable_api')): ?>
                                <a href="/share/<?php echo htmlentities($link); ?>/<?php echo htmlentities($account->id); ?>/unlock" class="btn btn-warning">手动解锁</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php if(count($accounts) > 1): ?>
            </div>
            <?php endif; ?>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <br>
    <?php echo $html; ?>
</div>

</body>
</html>

