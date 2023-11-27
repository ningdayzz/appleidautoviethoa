<?php
declare (strict_types=1);

namespace app\controller;

use app\BaseController;
use app\model\Account;
use app\model\Proxy;
use app\model\SharePage;
use app\model\User;
use Exception;
use think\response\Json;
use think\response\View;

class adminController extends BaseController
{
    public function index()
    {
        $account_count = $this->app->accountService->countAll();
        $share_count = $this->app->shareService->countAll();
        $user_count = $this->app->userService->countAll();
        return view('/admin/index', ['account_count' => $account_count, 'share_count' => $share_count, 'user_count' => $user_count]);
    }

    public function user()
    {
        $userList = $this->app->userService->fetchAll();
        return view('/admin/user', ['users' => $userList]);
    }

    public function userEdit($id)
    {
        $user = new User();
        $user = $user->fetch($id);
        if (!$user) {
            return alert("error", "Người dùng không tồn tại", "2000", "/admin/user");
        }
        return view('/admin/userDetail', ['user' => $user, 'action' => 'edit']);
    }

    public function userUpdate(): string
    {
        $user = new User();
        $user = $user->fetch($this->request->param('id'));
        if (!$user) {
            return alert("error", "người dùng không tồn tại", "2000", "/admin/user");
        }
        try {
            $data = [
                'id' => $user->id,
                'username' => $this->request->param('username'),
                'password' => $this->request->param('password'),
                'tg_bot_token' => $this->request->param('tg_bot_token'),
                'tg_chat_id' => $this->request->param('tg_chat_id'),
                'wx_pusher_id' => $this->request->param('wx_pusher_id'),
                'webhook' => $this->request->param('webhook'),
                'is_admin' => $this->request->param('is_admin') == 'on' ? 1 : 0,
            ];
        } catch (Exception $e) {
            return alert("error", "lỗi tham số", "2000", "/admin/user");
        }
        if ($user->updateUser($data)) {
            return alert("success", "sửa đổi thành công", "2000", "/admin/user");
        } else {
            return alert("error", "không thể chỉnh sửa", "2000", "/admin/user");
        }
    }

    public function userDelete($id): Json
    {
        $user = new User();
        return json($user->deleteUser($id));
    }

    public function account(): View
    {
        $accountList = $this->app->accountService->fetchAll();
        return view('/admin/account', ['accounts' => $accountList]);
    }

    public function accountEdit($id)
    {
        $account = new Account();
        $account = $account->fetch($id);
        if (!$account) {
            return alert("error", "Tài khoản không tồn tại", "2000", "/admin/account");
        }
        return view('/admin/accountDetail', ['account' => $account, 'action' => 'edit']);
    }

    public function accountUpdate($id = 0): string
    {
        try {
            $data = [
                'username' => $this->request->param('username'),
                'password' => $this->request->param('password'),
                'remark' => $this->request->param('remark'),
                'dob' => $this->request->param('dob'),
                'question1' => $this->request->param('question1'),
                'answer1' => $this->request->param('answer1'),
                'question2' => $this->request->param('question2'),
                'answer2' => $this->request->param('answer2'),
                'question3' => $this->request->param('question3'),
                'answer3' => $this->request->param('answer3'),
                'share_link' => $this->request->param('share_link'),
                'check_interval' => $this->request->param('check_interval'),
                'frontend_remark' => $this->request->param('frontend_remark'),
                'enable_check_password_correct' => $this->request->param('enable_check_password_correct') !== null,
                'enable_delete_devices' => $this->request->param('enable_delete_devices') !== null,
                'enable_auto_update_password' => $this->request->param('enable_auto_update_password') !== null,
                'min_manual_unlock' => $this->request->param('min_manual_unlock'),
                'enable' => $this->request->param('enable') !== null,
                'owner' => $this->request->param('owner'),
            ];
        } catch (Exception $e) {
            return alert("error", "lỗi tham số", "2000", "/admin/account");
        }
        $account = new Account();
        switch ($this->request->param('action')) {
            case "edit":
                $result = $account->updateAccount($id, $data);
                return alert($result['status'] ? "success" : "error", $result['msg'], "2000", "/admin/account");
            default:
                return alert("error", "hoạt động không xác định", "2000", "/admin/account");
        }
    }

    public function accountDelete($id): Json
    {
        $account = new Account();
        return json($account->deleteAccount($id));
    }

    public function share(): View
    {
        $shareList = $this->app->shareService->fetchAll();
        $shareURL = $this->request->domain() . "/share/";
        return view('/admin/share', ['shares' => $shareList, 'shareURL' => $shareURL]);
    }

    public function shareEdit($id)
    {
        $share = new SharePage();
        $share = $share->fetch($id);
        if (!$share) {
            return alert("error", "trang chia sẻ không tồn tại", "2000", "/admin/share");
        }
        $userAccountList = $this->app->accountService->fetchIDByOwner($share->owner);
        return view('/admin/shareDetail', ['share' => $share, 'accounts' => $userAccountList, 'action' => 'edit']);
    }

    public function shareUpdate($id = 0): string
    {
        try {
            $account_list = $this->request->param('account_list');
            if (!$account_list) {
                return alert("error", "Vui lòng chọn ít nhất một tài khoản", "2000", "/user/share" . $id == 0 ? "" : "/$id");
            }
            $accounts = implode(',', $account_list);
            $data = [
                'share_link' => $this->request->param('share_link'),
                'account_list' => $accounts,
                'password' => $this->request->param('password') == "" ? null : $this->request->param('password'),
                'owner' => $this->request->param('owner'),
                'html' => $this->request->param('html'),
                'remark' => $this->request->param('remark'),
                'expire' => $this->request->param('expire') == "" ? null : $this->request->param('expire'),
            ];
        } catch (Exception $e) {
            return alert("error", "lỗi tham số", "2000", "/user/share" . $id == 0 ? "" : "/$id");
        }
        $sharePage = new SharePage();
        switch ($this->request->param('action')) {
            case "edit":
                $sharePage = $sharePage->fetch($id);
                if (!$sharePage) {
                    return alert("error", "trang chia sẻ không tồn tại", "2000", "/admin/share");
                }
                $result = $sharePage->updateSharePage($sharePage->id, $data);
                return alert($result['status'] ? "success" : "error", $result['msg'], "2000", "/admin/share");
            default:
                return alert("error", "hoạt động không xác định", "2000", "/admin/share");
        }
    }

    public function shareDelete($id): Json
    {
        $sharePage = new SharePage();
        return json($sharePage->deleteSharePage($id));
    }

    public function proxy(): View
    {
        $proxyList = $this->app->proxyService->fetchAll();
        return view('/admin/proxy', ['proxies' => $proxyList]);
    }

    public function proxyEdit($id)
    {
        $proxy = new Proxy();
        $proxy = $proxy->fetch($id);
        if (!$proxy) {
            return alert("error", "proxy không tồn tại", "2000", "/admin/proxy");
        }
        $protocols = $this->app->proxyService->getProtocolList();
        return view('/admin/proxyDetail', ['proxy' => $proxy, 'action' => 'edit', 'protocols' => $protocols]);
    }

    public function proxyUpdate($id = 0): string
    {
        try {
            $data = [
                'protocol' => $this->request->param('protocol'),
                'content' => $this->request->param('content'),
                'status' => $this->request->param('status') !== null,
                'owner' => $this->request->param('owner'),
            ];
        } catch (Exception $e) {
            return alert("error", "lỗi tham số", "2000", "/admin/proxy" . $id == 0 ? "" : "/$id");
        }
        $proxy = new Proxy();
        switch ($this->request->param('action')) {
            case "edit":
                $proxy = $proxy->fetch($id);
                if (!$proxy) {
                    return alert("error", "proxy không tồn tại", "2000", "/admin/proxy");
                }
                return $proxy->updateProxy($proxy->id, $data) ?
                    alert("success", "sửa đổi thành công", "2000", "/admin/proxy") :
                    alert("error", "không thể chỉnh sửa", "2000", "/admin/proxy");
            case "add":
                return $proxy->addProxy($data) ?
                    alert("success", "Thêm thành công", "2000", "/admin/proxy") :
                    alert("error", "thêm không thành công", "2000", "/admin/proxy");
            default:
                return alert("error", "hoạt động không xác định", "2000", "/admin/proxy");
        }
    }

    public function proxyDelete($id): Json
    {
        $proxy = new Proxy();
        $result = [];
        $proxy = $proxy->fetch($id);
        if (!$proxy) {
            $result['msg'] = "proxy không tồn tại";
            $result['status'] = false;
        } else {
            $result['status'] = $proxy->deleteProxy($proxy->id);
            $result['msg'] = $result['status'] ? "xóa thành công" : "không thể xóa";
        }
        return json($result);
    }

    public function accountRestart($id): string
    {
        $account = new Account();
        $account = $account->fetch($id);
        if (!$account) {
            return alert("error", "Tài khoản không tồn tại", "2000", "/admin/account");
        }
        $backendResult = $this->app->backendService->restartTask($id);
        if ($backendResult['status']) {
            return alert("success", "khởi động lại thành công", "2000", "/admin/account");
        } else {
            return alert("error", "khởi động lại thất bại：" . $backendResult['msg'], "2000", "/admin/account");
        }
    }

    public function unlockRecord(): View
    {
        $unlockRecordList = $this->app->unlockService->fetchRecord();
        return view('/admin/unlockRecord', ['unlockRecords' => $unlockRecordList]);
    }

}
