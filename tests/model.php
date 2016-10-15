<?php
require_once("../lib/SDatabase.inc.php");
     $db = new SDatabase('../models.json'); // Open database

$ad_org="
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
$ad_tab="
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
$db->data['ad_org']=trim(preg_replace('/\s+/', ' ',$ad_org));
$db->data['ad_tab']=trim(preg_replace('/\s+/', ' ',$ad_tab));

$db->save();
