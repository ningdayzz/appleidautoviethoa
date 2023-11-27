<?php
declare (strict_types=1);

namespace app\command;

use app\model\UnlockRecord;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\facade\Db;

class DbClean extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('dbclean')
            ->addArgument('action', Argument::OPTIONAL, "Hành động làm sạch")
            ->setDescription('Được sử dụng để dọn sạch dữ liệu vô ích trong cơ sở dữ liệu');
    }

    protected function execute(Input $input, Output $output)
    {
        $action = $input->getArgument('action');
        switch ($action) {
            case 'ExpireShare':
                // 清理过期分享页
                $output->writeln('Bắt đầu dọn dẹp các trang chia sẻ đã hết hạn……');
                Db::name('share')->where('expire', '<', date('Y-m-d H:i:s'))->delete();
                $output->writeln('dọn dẹp hoàn thành');
                break;
            case 'UnlockRecord':
                // 清空解锁记录
                $output->writeln('Bắt đầu xóa hồ sơ mở khóa……');
                $unlockRecord = new UnlockRecord();
                $unlockRecord->truncate();
                break;
            default:
                $output->writeln('hành động dọn dẹp không xác định' . PHP_EOL);
                $output->writeln('Hành động dọn dẹp có sẵn：');
                $output->writeln('ExpireShare - Dọn dẹp các trang chia sẻ hết hạn');
                $output->writeln('UnlockRecord - xóa lịch sử mở khóa');
                break;
        }
    }
}
