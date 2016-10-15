SELECT 
  (select name from adempiere.ad_tab where ad_tab_id=ad_field_v.ad_tab_id)
  as name,array_agg(
  concat(
  'seqno:',seqno,
  'name:',
  ad_field_v.name , 
  ',display:',
  ad_field_v.isdisplayed, 
  ',reference:',
  (select name from adempiere.ad_reference where ad_reference_id=ad_field_v.ad_reference_id)
  ,
  (select name from adempiere.ad_process where ad_process_id=ad_field_v.ad_process_id)
  ,
  
  ad_field_v.sortno, 
  ad_field_v.columnsql, 
  ad_field_v.callout, 
  ad_field_v.defaultvalue, 
  ad_field_v.isparent, 
  ad_field_v.columnname, 
  ad_field_v.istoolbarbutton, 
  ad_field_v.ad_chart_id, 
  ad_field_v.included_tab_id, 
  ad_field_v.tablename, 
  ad_field_v.isupdateable))
 
FROM 
  adempiere.ad_field_v
WHERE 
  ad_field_v.ad_window_id = 143 and isdisplayed='Y'

group by 1

