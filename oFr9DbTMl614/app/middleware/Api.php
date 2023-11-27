<?php
declare (strict_types=1);

namespace app\middleware;

use Closure;

class Api
{
    public function handle($request, Closure $next)
    {
        if (!$request->isPost()) {
            return json(["code" => 403, "msg" => "phương pháp yêu cầu sai", "status" => false]);
        }
        $key = $request->header('key');
        if (!$key || $key == "") {
            return json(['code' => 401, 'msg' => 'chìa khóa không được cung cấp', "status" => false]);
        } else {
            $apikey = env('API_KEY');
            if ($key != $apikey) {
                return json(['code' => 403, 'msg' => 'chìa khóa sai', "status" => false]);
            } else {
                return $next($request);
            }
        }
    }
}
