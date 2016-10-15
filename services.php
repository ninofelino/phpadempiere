<?php 
require_once("SDatabase.inc.php");
     $db = new SDatabase('../adempiere.json'); // Open database
  //$sqldb = pg_connect("host=localhost dbname=cendold1_adempiere user=cendold1_test password=2Sz8kSoUnHdM options='--client_encoding=UTF8'") or die(pg_last_error());
   $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
  // $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;

 


function runsql($name,$sequel) {
   $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
     $db = new SDatabase('../adempiere.json'); // Open database
 
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
   // $db = new SDatabase('adempiere.json'); // Open database
  
    $db->data[$name]=trim($sequel);
    $db->data["info"]="adempiere";
   $db->save();
    }

$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$_SESSION["favcolor"] = "green";


// session_start();





switch($request[0]) {
  case "menu":

       break;
	case "db" :
             switch($request[1]){
              case "list":
                  
                    print_r($db->data);echo '<br>';
              break;
             }
          echo $GLOBALS['db']->data[$request[1]];
              


              
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
          case "ad_org":
                $sql="
           
            select row_to_json(s) from
            (
            select  t.org,t.description,array_to_json(array_agg(row_to_json(t))) as client
                   from 
                   (select a.name as org,r.name,a.description  from ad_org a
                    left outer join ad_client r on a.ad_org_id=r.ad_org_id
                       ) t   
                      group by 1,2
             ) s  
         
                   
            

                ";
                 $db = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere");
                 $x=0;

              $result=pg_query($db,$sql) or die(pg_last_error());
               $resultArray = pg_fetch_all($result);
             //echo json_decode($resultArray);
              while($row = pg_fetch_row($result)){
              	$x=++$x;
          $hasil .=$row[0].$row[1];    
      }
         // echo $hasil;
         runsql("org",$sql);
         break;
         case "ad_user":
               $sql="
                  select row_to_json(t) from
                  (
                  select name,phone,email,islocked,isactive from ad_user
                  ) t
               ";
               runsql('user',$sql);
         break;
    
          
  
}


	           //  c.columnname,//
	           //  b.ad_column_id,//
	           //  d.tablename //

?>

