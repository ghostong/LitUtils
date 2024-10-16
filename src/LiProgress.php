<?php

namespace Lit\Utils;

class LiProgress
{

    /**
     * pcntl 多线程
     * @date 2024/10/16
     * @param array $data
     * @param int $progressNum
     * @param null $callback
     * @return void
     * @author litong
     */
    public static function pcntl($data, $progressNum = 5, $callback = null, $logShow = true) {
        if (!extension_loaded('pcntl')) {
            die('pcntl 扩展未安装');
        }
        $dataChunk = array_chunk($data, $progressNum);
        foreach ($dataChunk as $values) {
            foreach ($values as $value) {
                $pid = pcntl_fork();
                if ($pid == -1) {
                    die('不能创建进程');
                } else if ($pid) {
                    // 父进程,继续创建下一个子进程
                    continue;
                } else {// 子进程
                    $process_id = posix_getpid();
                    if ($logShow) {
                        echo "子进程 $process_id 开始\n";
                    }
                    call_user_func($callback, $value);
                    if ($logShow) {
                        echo "子进程 $process_id 已完成\n";
                    }
                    exit(0);
                }
            }
            while (pcntl_waitpid(0, $status) != -1) {
                pcntl_waitpid(-1, $status);
                if ($logShow) {
                    echo "本轮 子进程 已全部退出\n";
                }
            }
        }
        if ($logShow) {
            echo "全部 子进程 已退出\n";
        }
    }
}