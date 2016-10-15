<?php
$jsoon = '[
  {"url":"Administration","icon":"x.svg","dataSource":"select * from ad_menu","templateurl":[
  {"url":"Organization","icon":"org.svg","templateurl":"org","datasource":"services/adempiere.php/ad_org"},
  {"url":"Client","icon":"client.svg","templateurl":"client","datasource":"index.php/sql/select * from ad_client"},
  {"url":"Roles","icon":"user.svg","templateurl":"role","datasource":"index.php/sql/select * from ad_role"},
  {"url":"User","icon":"user.svg","templateurl":"user","datasource":"index.php/sql/select * from ad_user"}
                                                                  
                                   ]},
                     {"url":"Window","icon":"window.svg","templateurl":[
      {"url":"tab","icon":"window.svg","templateurl":"tab","datasource":"services/adempiere.php/tab"},
                       {"url":"table","icon":"table.svg","templateurl":"table"},
                       {"url":"Reference","icon":"window.svg","templateurl":"ad_reference"},
                       {"url":"view","icon":"view.svg","templateurl":"view"},
                       {"url":"window","icon":"window.svg","templateurl":"window"}
                       
                       

                      ]},
         {"url":"Sql","icon":"sql.svg","templateurl":[
                     {"url":"product2","icon":"product.svg","templateurl":"product1"},
                     {"url":"Bussiness","icon":"bpartner.svg","templateurl":"produc5t"},
                     {"url":"Logon","templateurl":"logon","datasource":"select * from ad_user"},
                     {"url":"icon","templateurl":"icon"}

                                   ]}
   
                   

                      
                     ]

';
?>