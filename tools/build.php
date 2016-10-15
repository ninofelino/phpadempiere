<?php 
include "minifier.php";
echo '<a href="index.php">index</a>';
$string = file_get_contents("../adempiere.json");
$json_a = json_decode($string, true);

$myfile = fopen("index.php", "wb");
//fwrite($myfile, '<?php  ');
//fwrite($myfile, 'echo page_php();');
fwrite($myfile, file_get_contents("../core.php"));
//fwrite($myfile,'<?php echo base64_decode(page_php());  ' );
foreach($json_a as $key => $value) {
    
    $kompress=base64_encode($value);
    $rw="function ".str_replace('.','_',$key).'(){ return"'.$kompress.'";}  ';
    fwrite($myfile, $rw);
    if (gettype($value) == "object") {
        foreach ($value as $key => $value) {
                echo "value".$key;

        }
    }
}

$files = array_diff(scandir("../lib"), array('.', '..'));
foreach ($files as $key => $value) {
	$fn=str_replace('.','X',$value);
	$fn=str_replace('-','Z',$fn);
	fwrite($myfile,' function '.$fn.'() { return ');
fwrite($myfile,' "'.base64_encode(file_get_contents("../lib/".$value)).'"');
fwrite($myfile, " ;}");}

$files = array_diff(scandir("../directive"), array('.', '..'));
foreach ($files as $key => $value) {
	    if (!$data = file_get_contents('../directive/'.$value)) {
      $error = error_get_last();
      echo "HTTP request failed. Error was: " . $error['message'];
} else {
      echo "Everything went better than expected";
      $fn=str_replace('.','X',$value);
	$fn=str_replace('-','Z',$fn);
	fwrite($myfile,' function '.$fn.'() { return ');
fwrite($myfile,' "'.base64_encode(file_get_contents("../directive/".$value)).'"');
fwrite($myfile, " ;}");}

}

$files = array_diff(scandir("../directive/template"), array('.', '..'));
foreach ($files as $key => $value) {
	    if (!$data = file_get_contents('../directive/template'.$value)) {
      $error = error_get_last();
      echo "HTTP request failed. Error was: " . $error['message'];
} else {
      echo "Everything went better than expected";
      $fn=str_replace('.','X',$value);
	$fn=str_replace('-','Z',$fn);
	fwrite($myfile,' function '.$fn.'() { return ');
fwrite($myfile,' "'.base64_encode(file_get_contents("../directive/template".$value)).'"');
fwrite($myfile, " ;}");}

}

	
fclose($myfile);
?>