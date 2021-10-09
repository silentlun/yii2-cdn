<?php
/**
 * TargetAbstract.php
 * @author: silentlun
 * @date  2021年9月30日下午12:06:09
 * @copyright  Copyright igkcms
 */
namespace silentlun\cdn;

use Exception;
use yii\base\BaseObject;

abstract class TargetAbstract extends BaseObject implements TargetInterface
{
    
    public $domain;
    
    protected $lastError = null;
    
    protected $client;
    
    public function init()
    {
        parent::init();
        if( empty($this->domain) ) throw new Exception("Cdn domain cannot be blank");
        if (stripos($this->domain, 'http://') !== 0 && stripos($this->domain, 'https://') !== 0  && stripos($this->domain, '//') !== 0) {
            throw new Exception("domain must begin with http://, https:// or //");
        }
        if( $this->domain[strlen($this->domain) - 1] !== '/' ){
            $this->domain .= '/';
        }
    }
    
    public function getLastError()
    {
        return is_string( $this->lastError ) ? $this->lastError : print_r($this->lastError, true);
    }
    
    public function getCdnUrl($destFile)
    {
        if( strpos($destFile, '/') === 0 ){
            $destFile = substr($destFile, 1);
        }
        return $this->domain . $destFile;
    }
    
    public function getClient()
    {
        return $this->client;
    }
}