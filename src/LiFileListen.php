<?php

namespace Lit\Utils;

use SplFileObject;

/**
 * LiFileListen: 监听文件新增行
 * @author  litong
 * @since   1.0
 **/
class LiFileListen
{
    protected $fileList = [];
    protected $objectList = [];
    protected $fileInfos = [];

    public function __construct($fileList) {
        $this->fileList = $fileList;
    }

    public function run() {
        $this->fileInit($this->fileList);
        while (true) {
            foreach (array_keys($this->objectList) as $filePath) {
                if ($this->fileCheck($filePath)) {
                    $this->readFile($filePath);
                }
            }
            sleep(1);
        }
    }

    protected function fileInit($fileList) {
        foreach (array_keys($fileList) as $filePath) {
            $spl = new SplFileObject($filePath);
            $spl->seek(PHP_INT_MAX);
            $this->objectList[$filePath] = $spl;
            $this->setFileInfo($filePath, $spl->fstat());
        }
    }

    protected function fileCheck($filePath) {
        $stat = $this->objectList[$filePath]->fstat();
        $fileInfo = $this->getFileInfo($filePath);
        if ($fileInfo["mtime"] != $stat["mtime"] || $fileInfo["size"] != $stat["size"]) {
            $this->setFileInfo($filePath, $stat);
            return true;
        } else {
            return false;
        }
    }

    protected function setFileInfo($filePath, $stat) {
        $this->fileInfos[$filePath] = ["mtime" => $stat["mtime"], "size" => $stat["size"]];
    }

    protected function getFileInfo($filePath) {
        return isset($this->fileInfos[$filePath]) ? $this->fileInfos[$filePath] : ["mtime" => 0, "size" => 0];
    }

    protected function readFile($filePath) {
        $spl = &$this->objectList[$filePath];
        $spl->seek($spl->key());
        while ($line = $spl->current()) {
            call_user_func($this->fileList[$filePath], $line);
            $spl->next();
        }
    }
}