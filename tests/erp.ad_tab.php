Ad_tab
<?php
echo var_dump($_SERVER['PATH_INFO']);
?>
<div ng-repeat="item in related | limitTo:6 ">
	<li>
    <a href="ad_tab">	{{item.name}}</a>    {{related}}
	</li>
</div>