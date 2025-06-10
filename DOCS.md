# 简易文档

## 安装

### 发布配置

```` shell
php artisan vendor:publish --provider="Illustrator\WaplarServiceProvider" --tag="waplar-config"
````

### 发布所有资源（一般用于开发测试）

```` shell
php artisan vendor:publish --provider="Illustrator\WaplarServiceProvider" --tag="waplar"
````

### 发布测试资源

```` shell
php artisan vendor:publish --tag="waplar-test"
````