<?php
 $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
  
    $sequel="select (select name from ad_tab where ad_tab_id=a.ad_tab_id) as window,array_agg(concat('tab:',a.name,',','tablename',':',tablename,',','column',':',columnname,',','status',':',isdisplayed,seqno)) as name from ad_field_v a  where a.ad_window_id=143  group by 1";
    $result=pg_query($sqldb,$sequel) or die(pg_last_error());
    $resultArray = pg_fetch_all($result);
//    echo json_encode($resultArray);
    
    echo "[";
    $i=1;
    $jml=pg_num_rows($result);
    for($i=0;$i<pg_num_rows($result);$i++)
    {
//   echo "<br>";
   // echo ",**************";
//   echo "<br>";
    	
    echo '{"'.pg_field_name($result,0).'":"';
    echo pg_fetch_result($result, $i, 0).'","tab":[';
    // echo "<br>";
    
    $detail=preg_replace('/{"/','', pg_fetch_result($result, $i, 1)); 
    $detail=preg_replace('/"}/','', $detail);   
    $tab=explode('","',$detail);
   // echo "<br>";
    $jmljum=count($tab);
    for($j=0;$j<count($tab);$j++)
    {
    	// echo "<br>";
    	 echo "{";
      if($j>0){
     // echo '},{';
      }
      // echo  '*'.$tab[$j];
      $pt1=$tab[$j];
  $pt1=preg_replace("/:/",'":"',$tab[$j]);     
  $pt1=preg_replace("/,/",'","', $pt1)  ;
   echo '"'.$pt1.'"}';
   if  ($j<$jmljum-1){
      echo ',';	
}
  
    }
    if ($i<$jml-1)
    {
    echo ']},';

    }
  //  echo "<br>";
    }
    echo ']}]'
    ?>
          