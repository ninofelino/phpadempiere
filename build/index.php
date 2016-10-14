index.php
<?php
require_once "phar://felino.phar/common.php";
$config = parse_ini_file("config.ini");
AppManager::run($config);