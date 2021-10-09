<?php
/**
 * LocalTarget.php
 * @author: silentlun
 * @date  2021年9月30日下午2:37:55
 * @copyright  Copyright igkcms
 */
namespace silentlun\cdn;

use Exception;

class LocalTarget extends TargetAbstract implements TargetInterface
{
    public function upload($localFile, $destFile)
    {
        return true;
    }
    
    public function multiUpload($localFile, $destFile)
    {
        return true;
    }
    
    public function delete($destFile)
    {
        return true;
    }
    
    public function exists($destFile)
    {
        return false;
    }
    
    public function getClient()
    {
        throw new Exception("must use cdn can call this method");
    }
}