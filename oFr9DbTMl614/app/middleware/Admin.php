<?php
declare (strict_types=1);

namespace app\middleware;

use app\model\User;
use Closure;
use think\facade\Session;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('user_id')) {
            return response(alert("error", "vui lòng đăng nhập trước", "2000", "/index"));
        } else {
            $user = new User();
            $user = $user->fetch(Session::get('user_id'));
            if (!$user->is_admin) {
                return response(alert("error", "dBạn không có quyền truy cập trang này", "2000", "/user"));
            }
            return $next($request);
        }
    }
}
