<?php /*a:2:{s:52:"/www/wwwroot/autoapple.shop/view/share/password.html";i:1688836974;s:44:"/www/wwwroot/autoapple.shop/view/layout.html";i:1683542048;}*/ ?>
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
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>Chia sẻ tài khoản - yêu cầu mật khẩu</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4"
             style="display: flex;align-items: center;justify-content: center;height: 100vh;">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-lock"></i> Trang chia sẻ này được mã hóa</h3>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="password" class="form-label">Mật khẩu：</label>
                            <input type="password" class="form-control" id="password" name="password" required/>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
