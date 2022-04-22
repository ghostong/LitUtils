<?php

namespace Lit\Utils;

class LiFileType
{

    /**
     * 是否图片类型
     * @date 2022/4/22
     * @param $file
     * @return bool
     * @author litong
     */
    public static function isImage($file) {
        return self::mimeType($file) === "image";
    }

    /**
     * 是否视频类型
     * @date 2022/4/22
     * @param $file
     * @return bool
     * @author litong
     */
    public static function isVideo($file) {
        return self::mimeType($file) === "video";
    }

    /**
     * 是否音频类型
     * @date 2022/4/22
     * @param $file
     * @return bool
     * @author litong
     */
    public static function isAudio($file) {
        return self::mimeType($file) === "audio";
    }

    /**
     * 是否文本类型
     * @date 2022/4/22
     * @param $file
     * @return bool
     * @author litong
     */
    public static function isText($file) {
        return self::mimeType($file) === "text";
    }

    /**
     * 是否文件
     * @date 2022/4/22
     * @param $file
     * @return bool
     * @author litong
     */
    public static function isFile($file) {
        return is_file($file);
    }

    protected static function mimeType($file) {
        $mime = self::mime($file);
        return current(explode("/", $mime));

    }

    protected static function mime($file) {
        if (self::isFile($file)) {
            return strtolower(mime_content_type($file));
        } else {
            return "";
        }
    }
}