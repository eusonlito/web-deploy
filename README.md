# web-deploy

## Requirements

* PHP 5.4
* Composer | https://getcomposer.org/download/

## Install

```
$> git clone git@github.com:eusonlito/web-deploy.git
$> cd web-deploy
$> composer install
```

## Configuration

* Set write permissions to web service user to `storage/logs/` and `storage/assets/` folders
* Configuration files are in `config/` folder
* Create a copy into `config/custom/` to customize configurations
* At first, copy `config/auth.php` into `config/custom/` and configure a basic auth user/password
* Now you can login with http://yoursite.com/web-deploy/
