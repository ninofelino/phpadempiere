<?php 

function runsql($name,$sequel) {
  
  //$sqldb = pg_connect("host=localhost dbname=cendold1_adempiere user=cendold1_test password=2Sz8kSoUnHdM options='--client_encoding=UTF8'") or die(pg_last_error());
   $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
    // $sqldb->exec('SET search_path TO adempiere');
    $result=pg_query($sqldb,$sequel) or die(pg_last_error());
    $resultArray = pg_fetch_all($result);
    
    
   // json_encode($resultArray);
     while($row = pg_fetch_row($result)){
    $hasil .=$row[0].',';
   
    
      
      
      
   }      
   $hasil='['.$hasil.']';
   $hasil=str_replace(',]', ']',$hasil);
   echo $hasil;

   }

$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$_SESSION["favcolor"] = "green";


session_start();

$sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;




switch($request[0]) {
	case "login" :
          echo "list al object";
	      echo  $method;
	      echo  $_SESSION;
	      break;
	case "tab"  :
	      $sql="
          select row_to_json(z) from
	      (
	      select  row_to_json(d) from
          (
          select name as tab,
                ( 
	            Select array_to_json(array_agg(row_to_json(t)))
	            from (
	                  select a.name,b.columnname,c.tablename                  
	                  from ad_field a 
                      left outer join ad_column b on a.ad_column_id=b.ad_column_Id
                      left outer join ad_table  c on b.ad_table_id=c.ad_table_id
	                  where a.ad_tab_id=xx.ad_tab_id
	                  ) t limit 5
                )  as field from ad_tab xx where ad_window_id=275 limit 5
            ) d) z
            

           ";

          runsql("tab",$sql);
          break;
  
}


	           //  c.columnname,//
	           //  b.ad_column_id,//
	           //  d.tablename //

?>

