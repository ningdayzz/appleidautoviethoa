<?php
declare (strict_types=1);

namespace app\controller;

use app\BaseController;
use think\Request;
use think\response\View;

class ShareController extends BaseController
{
    public function index(Request $request): View
    {
        $share = $request->share;
        if (!$share) {
            return view('share/error', ['errorTitle' => 'thao tác sai thao tác sai', 'errorMsg' => 'yêu cầu bất hợp pháp']);
        }
        $accountList = $share->account_list;
        $accounts = [];
        foreach ($accountList as $accountID) {
            $account = $this->app->accountService->fetchInShare($accountID);
            if (!$account) {
                continue;
            } else {
                $account->status = ($account->message == "正常" || $account->message == "Normal") && ((time() - strtotime($account->last_check)) < (($account->check_interval + 2) * 60));
                $accounts[] = $account;
            }
        }
        // 账号随机排序
        if (env("share_random")) {
            shuffle($accounts);
        }
        return view('share/result', ['accounts' => $accounts, 'html' => $share->html, 'link' => $share->share_link]);
    }

    public function manualUnlock(Request $request): string
    {
        $id = $request->id;
        $link = $request->link;
        $result = $this->app->unlockService->unlock($id);
        if ($result['status']) {
            return alert('success', 'Nhiệm vụ đã được gửi và sẽ được tự động mở khóa sau', 2000, '/share/' . $link);
        } else {
            return alert('error', $result['msg'], 2000, '/share/' . $link);
        }
    }
}
