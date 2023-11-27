<?php /*a:3:{s:49:"/www/wwwroot/autoapple.shop/view/index/index.html";i:1691721800;s:44:"/www/wwwroot/autoapple.shop/view/layout.html";i:1683542048;s:50:"/www/wwwroot/autoapple.shop/view/index/footer.html";i:1691721721;}*/ ?>
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
<!DOCTYPE HTML>
<!--
    Dimension by HTML5 UP
    html5up.net | @ajlkn
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="/static/css/main.css"/>
    <noscript>
        <link rel="stylesheet" href="/static/css/noscript.css"/>
    </noscript>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <title>APPLE ID</title>
</head>

<body>

<div id="wrapper">
    <header id="header">
        <div class="logo">
            <span class="icon fa-clipboard-check"></span>
        </div>
        <div class="content">
            <div class="inner">
                <h1> APPLE ID </h1>
                <p>Trang quản lý id không mã xác nhận</p>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="#intro">Giới thiệu</a></li>
                <li><a href="#login">Đăng nhập</a></li>
                <?php if(env('enable_register')): ?>
                <li><a href="#register">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div id="main">

        <article id="login">
            <h2 class="major">Đăng nhập</h2>
            <form action="/user/login" method="post">
                <div class="field half first">
                    <label for="username">Tài khoản</label>
                    <input type="text" name="username" id="username" placeholder="Vui lòng nhập tên người dùng"/>
                </div>
                <div class="field half">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" id="password" placeholder="Vui lòng nhập mật khẩu"/>
                </div>
                <ul class="actions">
                    <li><input type="submit" value="Đăng nhập" class="primary special" name="login"/></li>
                </ul>
            </form>
        </article>
        <article id="register">
            <h2 class="major">Đăng kí</h2>
            <form action="/user/register" method="post">
                <div class="field half first">
                    <label for="username">Tài khoản</label>
                    <input type="text" name="username" id="username" placeholder="Vui lòng nhập tên người dùng"/>
                </div>
                <div class="field half">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" id="password" placeholder="Vui lòng nhập mật khẩu"/>
                </div>
                <ul class="actions">
                    <li><input type="submit" value="Đăng kí" class="primary special" name="register"/></li>
                </ul>
            </form>
        </article>
    </div>
    <footer id="footer">

</footer>
</div>
<div id="bg"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/skel/3.0.1/skel.min.js"></script>
<script src="/static/js/util.js"></script>
<script src="/static/js/main.js"></script>
<script>
    $(function () {
        $(window).load(function () {
            NProgress.done();
        });
        NProgress.set(0.0);
        NProgress.configure({showSpinner: false});
        NProgress.configure({minimum: 0.4});
        NProgress.configure({easing: 'ease', speed: 1200});
        NProgress.configure({trickleSpeed: 200});
        NProgress.configure({trickleRate: 0.2, trickleSpeed: 1200});
        NProgress.inc();
        $(window).ready(function () {
            NProgress.start();
        });
    });
</script>
</body>
</html>
