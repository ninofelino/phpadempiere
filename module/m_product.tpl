<md-content class="md-padding" layout-xs="column" layout="row">
<p>
   template m_product.tpl

   <br>
   <h3>"isactive":</h3> <small>membedakan barang yang masih digunakan dan discontinou</small>
    <h3>"isstocked":</h3> <small>barang yang terdapat pada stock dan discontinou</small>
   

   "upc":null,"sku":null,"c_uom_id":"100","salesrep_id":null,"issummary":"N","isstocked":"Y","ispurchased":"Y","issold":"Y",

   "isbom":"Y",

   "isinvoiceprintdetails":"N","ispicklistprintdetails":"N","isverified":"Y","c_revenuerecognition_id":null,"m_product_category_id":"109","classification":null,"volume":"0","weight":"0","shelfwidth":null,"shelfheight":null,"shelfdepth":null,"unitsperpallet":null,"c_taxcategory_id":"107","s_resource_id":null,"discontinued":"N","discontinuedby":null,"processing":null,"s_expensetype_id":null,"producttype":"I","imageurl":null,"descriptionurl":null,"guaranteedays":"180","r_mailtext_id":null,"versionno":null,"m_attributeset_id":"101","m_attributesetinstance_id":"0","downloadurl":null,"m_freightcategory_id":null,"m_locator_id":null,"guaranteedaysmin":"30","iswebstorefeatured":"N","isselfservice":"Y","c_subscriptiontype_id":null,"isdropship":"N","isexcludeautodelivery":"N","group1":null,"group2":null,"istoformule":null,"lowlevel":"0","unitsperpack":"1","discontinuedat":null,"copyfrom":null,"m_product_uu":"31fda1eb-715c-42d1-b846-0c4dd11b2ec8","m_parttype_id":null,"iskanban":"N","ismanufactured":"N","isphantom":"N","isownbox":"N"}]
   </p>
 </md-content>  
<md-content class="md-padding" layout-xs="column" layout="row">
<div layout="row" layout-wrap>
  <md-card flex="30" ng-repeat="item in related">
       
          {{item.name}}
          </br><small>
          {{item.description}}	
          </small>
          
       
  </md-card>
  </div>
 </md-content>
 