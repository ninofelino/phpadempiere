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
fwrite($myfile,'function angular_min_js() { return ');
fwrite($myfile,' "'.base64_encode(file_get_contents("../lib/angular.min.js")).'"');
fwrite($myfile, " ;}");
fclose($myfile);
?>