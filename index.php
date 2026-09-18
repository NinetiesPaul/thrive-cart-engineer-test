<?php

error_reporting(E_ALL ^ E_NOTICE);

use Pecee\SimpleRouter\SimpleRouter;

include 'vendor/autoload.php';

require_once 'helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require 'bootstrap/container.php';

require_once 'routes/routes.php';

SimpleRouter::setDefaultNamespace('Controllers');
SimpleRouter::start();
