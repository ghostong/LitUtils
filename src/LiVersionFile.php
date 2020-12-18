<?php


namespace Lit\Utils;


class LiVersionFile
{
    const NOT_WRITABLE_CODE = 100;  //目录或文件不可写
    const COPY_FILE_FAIL_CODE = 101; //复制文件失败
    const WRITE_FILE_FAIL_CODE = 102; //写入文件失败
    const RENAME_FAIL_CODE = 103; //重命名文件失败
    const NOT_READABLE_CODE = 104; //文件不可读
    const FILE_NOT_EXISTS_CODE = 105; //文件不存在
    const DELETE_FAIL_CODE = 105; //删除失败

    const FILE_VERSION_MIDDLE = '.ver.'; //文件版本分隔符

    /**
     * 写入版本文件
     * @date 2020/12/18
     * @param string $filePath 文件保存路径
     * @param string $fileName 文件名称
     * @param string $versionPath 历史版本保存路径
     * @param string $content 文件内容
     * @return array ["file"=>"文件路径", "version_file"=>"上一版本文件路径"]
     * @throws \Exception
     * @author litong
     */
    public static function put($filePath, $fileName, $versionPath, $content) {
        $file = self::makePath($filePath, $fileName);
        if (is_file($file)) {
            $versionTmp = self::makePath($versionPath, $fileName);
            $versionName = self::versionFileName($versionTmp);
            self::copyFile($file, $versionName);
            self::writeFile($file, $content);
        } else {
            $versionName = "";
            self::writeFile($file, $content);
        }
        return ["file" => $file, "version_file" => $versionName];
    }

    /**
     * 获取文件历史版本
     * @date 2020/12/18
     * @param string $versionPath 历史版本文件存储路径
     * @param string $fileName 原始文件名称
     * @return \Generator
     * @throws \Exception
     * @author litong
     */
    public static function versionFileList($versionPath, $fileName) {
        self::isReadable(self::makePath($versionPath, $fileName));
        $di = new \DirectoryIterator($versionPath);
        foreach ($di as $val) {
            if (!$val->isDot() && $val->isFile()) {
                if (strpos($val->getFilename(), $fileName . self::FILE_VERSION_MIDDLE) === 0) {
                    yield $val->getFilename();
                }
            }
        }
    }

    /**
     * 删除版本文件
     * @date 2020/12/18
     * @param string $versionPath 历史版本文件存储路径
     * @param string $versionFileName 历史版本文件名称
     * @return bool
     * @throws \Exception
     * @author litong
     */
    public static function deleteVersionFile($versionPath, $versionFileName) {
        $versionFile = self::makePath($versionPath, $versionFileName);
        self::isWritable($versionFile);
        if (is_file($versionFile)) {
            if (unlink($versionFile)) {
                return true;
            } else {
                throw new \Exception(sprintf('delete fail %s !!', $versionFile), self::DELETE_FAIL_CODE);
            }
        } else {
            throw new \Exception(sprintf('file not exists %s !!', $versionFile), self::FILE_NOT_EXISTS_CODE);
        }
    }

    /**
     * 内容写入文件
     * @date 2020/12/18
     * @param $filePath
     * @param $content
     * @return bool
     * @throws \Exception
     * @author litong
     */
    public static function writeFile($filePath, $content) {
        self::isWritable($filePath);
        if (file_put_contents(self::latestFileName($filePath), $content)) {
            if (!rename(self::latestFileName($filePath), $filePath)) {
                throw new \Exception(sprintf('rename %s to %S fail !!', self::latestFileName($filePath), $filePath), self::RENAME_FAIL_CODE);
            }
            return true;
        } else {
            throw new \Exception(sprintf('write file %s fail !!', $filePath), self::WRITE_FILE_FAIL_CODE);
        }
    }

    private static function versionFileName($filePath) {
        self::isWritable($filePath);
        return $filePath . self::FILE_VERSION_MIDDLE . date("YmdHis") . mt_rand(10000000, 99999999);
    }

    private static function latestFileName($filePath) {
        return $filePath . self::FILE_VERSION_MIDDLE . "latest";
    }

    private static function copyFile($filePath, $versionFile) {
        if (!copy($filePath, $versionFile)) {
            throw new \Exception(sprintf('copy file %s to %s !!', $filePath, $versionFile), self::COPY_FILE_FAIL_CODE);
        }
        return true;
    }

    private static function isWritable($filePath) {
        if (!is_writable(dirname($filePath))) {
            throw new \Exception(sprintf('%s is not writable !!', dirname($filePath)), self::NOT_WRITABLE_CODE);
        }
        return true;
    }

    private static function isReadable($filePath) {
        if (!is_readable(dirname($filePath))) {
            throw new \Exception(sprintf('%s is not readable !!', dirname($filePath)), self::NOT_READABLE_CODE);
        }
        return true;
    }

    private static function makePath($path, $file) {
        return rtrim($path, "\\/") . DIRECTORY_SEPARATOR . $file;
    }

}