<?php
require_once("SDatabase.inc.php");
$db = new SDatabase('../erpclass.json'); // Open database
$src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js";

$db->data[basename($src)]=file_get_contents($src);
   

$db->save();
?>