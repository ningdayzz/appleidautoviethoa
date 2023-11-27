<?php
declare (strict_types=1);

namespace app\service;

use app\model\UnlockRecord;
use think\facade\Db;
use think\Paginator;
use think\Service;

class UnlockService extends Service
{
    public function register()
    {
        $this->app->bind('unlockService', UnlockService::class);
    }

    public function unlock($id)
    {
        if (!env("backend.enable_api")) {
            return ['status' => false, 'msg' => 'API phụ trợ không được bật'];
        }
        $account = Db::name('account')
            ->field('min_manual_unlock')
            ->where('id', $id)
            ->find();
        if (count($account) == 0) {
            return ['status' => false, 'msg' => 'Tài khoản không tồn tại'];
        }
        $min_manual_unlock = $account['min_manual_unlock'];
        if ($min_manual_unlock == 0) {
            return ['status' => false, 'msg' => 'Mở khóa thủ công không được bật cho tài khoản này'];
        }
        $timeAgo = date('Y-m-d H:i:s', time() - $min_manual_unlock * 60);
        $result = Db::name('unlock_record')
            ->where('account_id', $id)
            ->where('status', 1)
            ->where('type', 'manual')
            ->where('time', '>', $timeAgo)
            ->count();
        if ($result > 0) {
            return ['status' => false, 'msg' => 'Khoảng thời gian quá ngắn, hiện tại không cho phép mở khóa thủ công'];
        } else {
            $backendResult = $this->app->backendService->restartTask($id);
            $record = new UnlockRecord();
            $record->addRecord([
                'account_id' => $id, 'type' => 'manual',
                'status' => $backendResult['status'],
                'message' => $backendResult['msg'],
                'time' => date('Y-m-d H:i:s'),
                'ip' => getUserIP()
            ]);
            return $backendResult;
        }
    }

    public function fetchRecord($userID = 0): Paginator
    {
        return Db::name('unlock_record')
            ->join('account', 'unlock_record.account_id=account.id')
            ->field('unlock_record.*,account.username')
            ->order('unlock_record.id desc')
            ->where('account.owner', 'LIKE', $userID == 0 ? "%" : $userID)
            ->paginate(10);
    }
}
