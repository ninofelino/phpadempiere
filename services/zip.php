<php?
$files_to_zip = array(
	'adempiere.json',
	
);
//if true, good; if false, zip creation failed
$result = create_zip($files_to_zip,'adempiere.zip');