<?php
declare (strict_types=1);

namespace app\middleware;

use Closure;
use think\facade\Session;

class Auth
{

    public function handle($request, Closure $next)
    {
        // 是否已经登陆
        if (Session::get('user_id')) {
            return response(alert("error", "bạn đã đăng nhập", "2000", "/user/index"));
        }
        // 检查是否存在用户名密码
        if (!$request->param('username') || !$request->param('password')) {
            return response(alert("error", "Tên người dùng hoặc mật khẩu không được để trống", "2000", "/index"));
        }
        // 检查是否有登录或注册操作
        if ($request->param('login') xor $request->param('register')) {
            return $next($request);
        } else {
            return response(alert("error", "hoạt động không xác định", "2000", "/index"));
        }
    }
}
