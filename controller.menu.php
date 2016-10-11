<?php

$url = 'http://localhost:8080/models.php';

$options = array(
    CURLOPT_RETURNTRANSFER => true,   // return web page <-- This is the important one that tells cURL you want a response.
    CURLOPT_HEADER         => false,  // don't return headers
    CURLOPT_FOLLOWLOCATION => true,   // follow redirects
    CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
    CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
    CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
    CURLOPT_TIMEOUT        => 120,    // time-out on response
); 
//$ch = curl_init($url);
//curl_setopt_array($ch, $options);
//$result = curl_exec($ch);

//curl_close($ch);

var_dump($responseData->results);


$json = file_get_contents('menu.json', FILE_USE_INCLUDE_PATH);
//echo $json;
//echo var_dump(json_decode($json));
$tagasal=json_decode($json, true);
  echo $tagasal->templateurl[0]->url;  
print $tagasal['templateurl'][0]['url'];
echo "yyyyyyyyyyyyyyyyyyyyyy";

function state($tgs)
{
  
 //  $data->results[0]->geometry->location->lat
	$tags=$tgs;
	$tag="";
$hasil="";
foreach ($tags as $tag) {
  // do something with tag
	$hasil .= "<br>";
	$hasil .=".state('";
	$hasil .=$tag["url"];
    $hasil .="',{templateUrl:'";
	$hasil .=$tag["templateUrl"];
	$hasil .="',";
	$hasil .="controller: function(@scope,@http,@stateParams,@timeout)";
	$hasil .="{@scope.title='".@name."';";
	$hasil .="@http.get('".$tag["dataSource"]."').then(function(response){ @scope.related = response.data; })";
	$ar=$tag["url"].$tag["icon"]."','".$tag["templateUrl"]."'";
	if ($tag["templateUrl"]="Array") {
		$ar=$tag["templateUrl"];
		echo "<br>dump";
		echo var_dump($ar);
		echo "print r:";
		print_r($ar);
		// echo  $ar['url'];
	    print_r((array) json_decode($ar));
		//$hasil .=state($ar);
	}

	     
}
 return str_replace('@','$', $hasil);
}
echo state($tagasal);
?>