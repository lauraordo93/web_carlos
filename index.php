<?php
require_once __DIR__ . '/app/config/config.php';

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once APPROOT . '/config/helpers.php';
require_once APPROOT . '/core/Database.php';
require_once APPROOT . '/core/Controller.php';
require_once APPROOT . '/core/Model.php';
require_once APPROOT . '/core/App.php';

$app = new App();