<?php
namespace Selenium\Util;

use Exception\FailedGetContentsException;

/**
 * Class Common
 *
 * @package Selenium\Util
 */
class Common
{
    /**
     * @param string $filename
     * @return string
     * @throws FailedGetContentsException
     */
    public static function fileGetContents($filename)
    {
        $contents = @file_get_contents($filename);
        if (!$contents) {
            throw new FailedGetContentsException('Failed to get file contents.');
        }

        return $contents;
    }

    /**
     * @param string $file
     * @return \SimpleXMLElement
     * @throws FailedGetContentsException
     */
    public static function loadXmlString($file)
    {
        $xmlObject = @simplexml_load_string($file);
        if (!$xmlObject) {
            throw new FailedGetContentsException('Failed to load xml file.');
        }

        return $xmlObject;
    }
}
