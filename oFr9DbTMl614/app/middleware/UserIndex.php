<?php
declare (strict_types=1);

namespace app\middleware;

use Closure;
use think\facade\Session;

class UserIndex
{

    public function handle($request, Closure $next)
    {
        if (!Session::get('user_id')) {
            return response(alert("error", "vui lòng đăng nhập trước", "2000", "/index"));
        } else {
            return $next($request);
        }
    }
}
