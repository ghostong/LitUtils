<?php

namespace Lit\Utils;

use DirectoryIterator;

class LiFileOperator
{
    /**
     * 列出目录中所有的文件
     * @date 2023/4/25
     * @param string $dir 目录
     * @param bool $recursive 是否递归
     * @return \Generator
     * @author litong
     */
    public static function listFiles($dir, $recursive = false) {
        if ($recursive) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
            );
        } else {
            $iterator = new \DirectoryIterator($dir);
        }
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                yield $file->getPathname();
            }
        }
    }

    /**
     * 列出目录中所有的目录
     * @date 2023/4/25
     * @param string $dir 目录
     * @param bool $recursive 是否递归
     * @return \Generator
     * @author litong
     */
    public static function listDirs($dir, $recursive = false) {
        if ($recursive) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \FilesystemIterator::CURRENT_AS_SELF)
            );
            foreach ($iterator as $dir) {
                if ($dir->isDot() && substr($dir->getPathname(), -2) == '..') {
                    yield dirname($dir->getPathname());
                }
            }
        } else {
            $iterator = new \DirectoryIterator($dir);
            foreach ($iterator as $dir) {
                if ($dir->isDir() && !$dir->isDot()) {
                    yield $dir->getPathname();
                }
            }
        }
    }

    /**
     * 目录结构转换为数组结构
     * @date 2023/6/16
     * @param string $dir 目录
     * @return array
     * @author litong
     */
    public static function dirToArray($dir) {
        $result = [];
        $iterator = new DirectoryIterator($dir);
        foreach ($iterator as $entry) {
            if ($entry->isDot()) {
                continue;
            }
            $path = $entry->getPathname();
            if ($entry->isDir()) {
                $subdirectory = self::dirToArray($path);
                $result[] = [
                    'type' => 'dir',
                    'name' => $entry->getFilename(),
                    'children' => $subdirectory
                ];
            } else {
                $result[] = [
                    'type' => 'file',
                    'name' => $entry->getFilename()
                ];
            }
        }
        return $result;
    }

    /**
     * 获取一个临时文件存储目录
     * @date 2023/11/10
     * @return false|string
     * @author litong
     */
    public static function getTmpFileName() {
        return tempnam(sys_get_temp_dir(), "php_tmp_");
    }

    /**
     * 文件写入临时文件
     * @date 2023/11/10
     * @param $data
     * @return string
     * @author litong
     */
    public static function writeToTmpFile($data) {
        if ($tmpName = self::getTmpFileName()) {
            file_put_contents($tmpName, $data);
            return $tmpName;
        } else {
            return "";
        }
    }

    /**
     * @deprecated
     */
    public static function writeToTpmFile($data) {
        return self::writeToTmpFile($data);
    }


    const ATIME = 'atime';
    const CTIME = 'ctime';
    const MTIME = 'mtime';

    /**
     * 列出符合时间条件的文件
     * @date 2023/12/26
     * @param $dir
     * @param string $timeType atime|ctime|mtime
     * @param null|callable $callback
     * @return array
     * @author litong
     */
    public static function listFilesByTime($dir, $timeType, $callback = null) {
        $iterator = new \DirectoryIterator($dir);
        $return = [];
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                switch ($timeType) {
                    case  self::ATIME:
                        $fileTime = $file->getATime();
                        break;
                    case self::MTIME:
                        $fileTime = $file->getMTime();
                        break;
                    default:
                        $fileTime = $file->getCTime();
                        break;
                }
                if (is_callable($callback)) {
                    call_user_func($callback, $fileTime, $file->getFilename());
                } else {
                    $return[] = ['file_time' => $fileTime, 'real_path' => $file->getFilename()];
                }
            }
        }
        return $return;
    }
}