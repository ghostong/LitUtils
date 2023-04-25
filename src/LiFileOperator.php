<?php

namespace Lit\Utils;

class LiFileOperator
{
    /**
     * 列出目录中所有的文件
     * @date 2023/4/25
     * @param $dir
     * @param bool $recursive
     * @return array
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
        $files = [];
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[] = $file->getPathname();
            }
        }
        return $files;
    }

    /**
     * 列出目录中所有的目录
     * @date 2023/4/25
     * @param $dir
     * @param bool $recursive
     * @return array
     * @author litong
     */
    public static function listDirs($dir, $recursive = false) {
        $dirs = [];
        if ($recursive) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \FilesystemIterator::CURRENT_AS_SELF)
            );
            foreach ($iterator as $dir) {
                if ($dir->isDot() && substr($dir->getPathname(), -2) == '..') {
                    $dirs[] = dirname($dir->getPathname());
                }
            }
        } else {
            $iterator = new \DirectoryIterator($dir);
            foreach ($iterator as $dir) {
                if ($dir->isDir() && !$dir->isDot()) {
                    $dirs[] = $dir->getPathname();
                }
            }
        }
        return $dirs;
    }
}