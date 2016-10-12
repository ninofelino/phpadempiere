<?php
    session_start();
    $_SESSION['hello'] = 'world';
   echo "<h3> PHP List All Session Variables</h3>";
   foreach ($_SESSION as $key=>$val)
    echo $key." ".$val."<br/>";

    echo "<pre>";
print_r($_SESSION);
echo "</pre>";

	
?>