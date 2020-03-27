<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// Load .env configuration
$repository = Dotenv\Repository\RepositoryBuilder::create()
    ->withReaders([
        new Dotenv\Repository\Adapter\EnvConstAdapter(),
    ])
    ->withWriters([
        new Dotenv\Repository\Adapter\EnvConstAdapter(),
        new Dotenv\Repository\Adapter\PutenvAdapter(),
    ])
    ->immutable()
    ->make();
$dotenv = Dotenv\Dotenv::create($repository, __DIR__.'../');
$dotenv->required('DB_DSN')->notEmpty();
$dotenv->load();

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();


// для предотвращения скачивания .env файла выносим его за пределы DOCUMENT_ROOT (/web/), т.е. в корень проекта
// если есть возможность, так же добавить запрет на доступ к .env файлу в конфиге веб сервера
