<?php

require_once("SDatabase.inc.php");


class erp
{

    public $ad_window_id;
     public $obj=array();
     public $db;
    public $objsql=array();
    function get_tab(){
             return exec('ad_tab');
    }
    
     function exectojson($sequel,$whereClause)
    {
        error_log("sequel is :".$sequel);
        $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
       
   
        $result=pg_query($sqldb,$sequel) or die(error_log($sequel));
        $resultArray = pg_fetch_all($result);
     return json_encode($resultArray);
     
    }


    function exec($sequel,$whereClause)
    {
        error_log("sequel is :".$sequel);
        $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
        $db = new SDatabase('../erpclass.json'); // Open database
   
        $result=pg_query($sqldb,$db->data[$sequel]) or die(error_log($sequel));
        $resultArray = pg_fetch_all($result);
     //   return json_encode($resultArray);
        //return $resultArray;
            while($row = pg_fetch_row($result)){
          $hasil .=$row[0].',';    
    }      
    $hasil='['.$hasil.']';
    $hasil=str_replace(',]', ']',$hasil);
    return $hasil;
      //  return $db->data[$sequel];

    }
	function initObj(){
	$db = new SDatabase('../erpclass.json'); // Open database
   

	$db->data['ad_tab']="
	      select row_to_json(z) from
	      (
	      select  row_to_json(d) from
          (
          select name ,
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
            
	        

	    $db->data['ad_table']=" 
	          select row_to_json(t) from
                  (
                  select ad_reference_id,(select name from ad_reference where ad_reference_id=a.ad_reference_id),
                  defaultvalue,isupdateable,ismandatory,(select name from ad_process where ad_process_id=a.ad_process_id),
                  (select tablename from ad_table where ad_table_id=a.ad_table_Id),a.columnname,ad_table_id
                    from 
                  ad_column a  where ad_table_id=100 order by a.ad_column_Id
                  ) t
               
	       ";
	    $db->data["ad_reference"]="
                select row_to_json(t) from
                (
	              select * from ad_reference a
                order by ad_reference_id
	              ) t
	             ";

	    
	    $db->data["ad_window"]="
      select row_to_json(t) from
      (
      select name,ad_window_id,concat('ad_tab',ad_window_id) as link from ad_window
      ) t
      ";

      $db->data["window"]="
       select row_to_json(r) from
      (
       select a.name,array_agg(t) as field from
      ad_tab a 
      left outer join
      (
      select c.ad_tab_id,c.name,d.columnname,e.name as reference,
      c.isdisplayed,c.xposition,e.ad_reference_id as refid,
      case when e.ad_reference_id=19 then
           (select array_agg(x) from (select name,value from ad_org) x ) 
      end   

      as select ,
      case when  e.ad_reference_id=19 then 'll'
           else 'blank'
      end as selec    
      from ad_field c
      left outer join ad_column d on c.ad_column_id=d.ad_column_id
      left outer join ad_reference e on d.ad_reference_id=e.ad_reference_id
      left outer join ad_ref_list f on e.ad_reference_id=f.ad_reference_id
      
      where c.isdisplayed='Y' order by c.seqno
       )t  on  a.ad_tab_id=t.ad_tab_id where a.ad_window_id=200005 group by 1) r
      ";



	$db->save();
         return $db;
	}
	


}
?>