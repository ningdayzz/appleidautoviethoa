<?php
declare (strict_types=1);

namespace app\middleware;

use app\model\SharePage;
use Closure;

class Share
{
    public function handle($request, Closure $next)
    {
        $shareLink = $request->param('link');
        if (!$shareLink) {
            return view('share/error', ['errorTitle' => 'trang không tồn tại', 'errorMsg' => 'Liên kết chia sẻ này không tồn tại']);
        }
        if ($request->param('id')){
            // 触发手动解锁
            $request->id = $request->param('id');
            $request->link = $shareLink;
            return $next($request);
        }
        $share = new SharePage();
        $share = $share->fetchByLink($shareLink);
        if (!$share) {
            return view('share/error', ['errorTitle' => 'trang không tồn tại', 'errorMsg' => 'Liên kết chia sẻ này không tồn tại']);
        }
        if ($share->password) {
            if (!$request->param('password')) {
                return view('share/password', ['link' => $shareLink]);
            }
            if ($request->param('password') != $share->password) {
                return view('share/error', ['errorTitle' => 'sai mật khẩu', 'errorMsg' => 'Lỗi mật khẩu liên kết chia sẻ']);
            }
        }
        if ($share->expire != null && strtotime($share->expire) < time()) {
            return view('share/error', ['errorTitle' => 'trang đã hết hạn', 'errorMsg' => 'Liên kết chia sẻ này đã hết hạn']);
        }
        $request->share = $share;
        return $next($request);
    }
}
