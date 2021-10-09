yii2-cdn
========
yii2 上传文件扩展，目前仅支持本地和七牛云，其他云存储待补充。

Installation
------------

安装此扩展的首选方法是通过 [composer](http://getcomposer.org/download/).

Either run

```
php composer require --prefer-dist silentlun/yii2-cdn "*"
```

or add

```
"silentlun/yii2-cdn": "*"
```

to the require section of your `composer.json` file.


## 使用方法

### 1.配置组件  :

安装扩展后，打开common/config/main.php在components块内增加 :

1.使用本地存储的配置
```php
	'components' => [
	    'cdn' => [
	        'class' => 'silentlun\cdn\LocalTarget',
	        'domain' => '本地cdn域名',
	    ]
	]
```

2.使用七牛云的配置
```php
	'components' => [
	    'cdn' => [
	        'class' => 'silentlun\cdn\QiniuTarget',
			'accessKey' => '七牛key',
			'secretKey' => '七牛secret',
			'bucket' => '七牛bucket',
			'domain' => '七牛cdn域名',
	    ]
	]
```

### 2.控制器中使用
```php
	$localFile = '本地路径';
	$destFile = '上传路径';
	$cdn = Yii::$app->cdn;
	$cdn->upload($localFile, $destFile);
	$imgUrl = $cdn->getCdnUrl($destFile);
```