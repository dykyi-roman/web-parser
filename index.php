<?php

require_once "vendor/autoload.php";

use Dotenv\Dotenv;
use Dykyi\App\Application;

(new Dotenv(__DIR__))->load();
(new Application(php_sapi_name()))->run();