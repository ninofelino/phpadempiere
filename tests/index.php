<?php
include 'php/erp.php';
$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

$erp=new erp;
$erp->initObj();
$debug=5;
$sql="
select id,windows,tab,array_to_json(array_agg(t.field)) as field from
(
select a.ad_window_id as id,a.name as windows,b.name as tab,c.name as field,d.columnname
,e.name as reference
from ad_window a 
left outer join ad_tab b on a.ad_window_id=b.ad_window_id
left outer join ad_field c on b.ad_tab_id=c.ad_tab_id
left outer join ad_column d on c.ad_column_id=d.ad_column_id
left outer join ad_reference e on d.ad_reference_id=e.ad_reference_id
where a.ad_window_id=200005
) t group by 1,2,3
";
$sql="

      select (select name from ad_window where ad_window_id=a.ad_window_id) as window,a.name,row_to_json(t) as field from
      ad_tab a 
      left outer join
      (
      select c.ad_tab_id,c.name,d.columnname,e.name as reference 
      from ad_field c
      left outer join ad_column d on c.ad_column_id=d.ad_column_id
      left outer join ad_reference e on d.ad_reference_id=e.ad_reference_id
       )t  on  a.ad_tab_id=t.ad_tab_id where a.ad_window_id=200005";
//echo $erp->exec($sql,$sql);
//echo $erp->exec($request[0]);
//echo $_SERVER['PATH_INFO'].request[1];
error_log("PATH INFO".$_SERVER['PATH_INFO']);
error_log("Request 0: ".$request[0]);
error_log("Request 1: ".$request[1]);
// home -> fronpage
// db   -> database
// util -> utility
// {"name":"application"}
//           -> state       application.state
//             -> controller  application.controller |
//             -> directive   application.directive  | generate ../mvc
//             -> datasource  db/datasource

  	echo $erp->exec($request[0],$request[1]);
    
?>