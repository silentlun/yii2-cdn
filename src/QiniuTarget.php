<?php
/**
 * QiniuTarget.php
 * @author: silentlun
 * @date  2021年9月30日下午2:38:34
 * @copyright  Copyright igkcms
 */
namespace silentlun\cdn;

use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Exception;

class QiniuTarget extends TargetAbstract
{
    public $accessKey;
    
    public $secretKey;
    
    public $bucket;
    
    /** @var  BucketManager */
    protected $client;
    
    protected $lastError = null;
    
    public function init()
    {
        parent::init();
        if( empty($this->accessKey) ) throw new Exception("Qiniu accessKey cannot be blank");
        if( empty($this->secretKey) ) throw new Exception("Qiniu secretKey cannot be blank");
        if( empty($this->bucket) ) throw new Exception("Cdn bucket cannot be blank");
        $this->client = $this->getBucketManager();
    }
    
    public function upload($localFile, $destFile)
    {
        $token = $this->getAuth()->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $destFile, $localFile);
        if ($err !== null) {
            $this->lastError = $err;
            return false;
        } else {
            return true;
        }
    }
    
    public function multiUpload($localFile, $destFile)
    {
        $this->upload($localFile, $destFile);
    }
    
    public function delete($destFile)
    {
        $err = $this->client->delete($this->bucket, $destFile);
        if ($err) {
            $this->lastError = $err;
            return false;
        }
        return true;
    }
    
    public function exists($destFile)
    {
        list($fileInfo, $err) = $this->client->stat($this->bucket, $destFile);
        if ($err) {
            return false;
        } else {
            return true;
        }
    }
    
    public function getAuth()
    {
        return new Auth($this->accessKey, $this->secretKey);
    }
    
    private function getBucketManager()
    {
        return new BucketManager($this->getAuth(), new Config());
    }
    
}