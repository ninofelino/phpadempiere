snippet.php
<?php
$files = array_diff(scandir("../lib"), array('.', '..'));
$angularZanimateXminXjs=0;
$angularanimateXminXjs="ll";
foreach ($files as $key => $value) {
	$fn=str_replace('.','X',$value);
	$fn=str_replace('-','Z',$fn);
	$g=";";
	echo $fn."<br>";
}