<?php
 $dh = opendir('C:/Users/nino/Documents/phpfel/images');
 while ($file = readdir($dh))
 {
 echo '<img src="images/'.$file.'" alt="l"></img>'.$file;
}
 closedir($dh);

 



 
?>