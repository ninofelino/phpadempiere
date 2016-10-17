template
<script >
//	  app.controller('Ctrl', function($scope) 
  //     {
    //      $scope.title="jjjj";
     
   // });

</script>

<script type="text/javascript">
    window.onload = function () {
      var tree = document.getElementById("tree");
      var lists = [ tree ];
     
      for (var i = 0; i < tree.getElementsByTagName("ul").length; i++)
        lists[lists.length] = tree.getElementsByTagName("ul")[i];

      for (var i = 0; i < lists.length; i++) {
        var item = lists[i].lastChild;
     	 
        while (!item.tagName || item.tagName.toLowerCase() != "li")
     	  item = item.previousSibling;

        item.className += " last";
      }
    }
  </script>
<div>
{{title}}
</div>
{{title}}

<style type="text/css">
ul.tree, ul.tree ul {
     list-style-type: none;
   }

   ul.tree, ul.tree ul {
     list-style-type: none;
     background: url(vline.png) repeat-y;
     margin: 0;
     padding: 0;
   }
   
   ul.tree ul {
     margin-left: 10px;
   }

   ul.tree li {
     margin: 0;
     padding: 0 12px;
   }
   ul.tree, ul.tree ul {
     list-style-type: none;
     background: url(vline.png) repeat-y;
     margin: 0;
     padding: 0;
   }
   
   ul.tree ul {
     margin-left: 10px;
   }

   ul.tree li {
     margin: 0;
     padding: 0 12px;
     line-height: 20px;
     background: url(node.png) no-repeat;
     color: #369;
     font-weight: bold;

   ul.tree, ul.tree ul {
     list-style-type: none;
     background: url(vline.png) repeat-y;
     margin: 0;
     padding: 0;
   }
   
   ul.tree ul {
     margin-left: 10px;
   }

   ul.tree li {
     margin: 0;
     padding: 0 12px;
     line-height: 20px;
     background: url(node.png) no-repeat;
     color: #369;
     font-weight: bold;
   }

   ul.tree li.last {
     background: #fff url(lastnode.png) no-repeat;
   }

   }
</style>
<?php
echo var_dump($_SERVER['PATH_INFO']);
?>
state parameter  {{id}}
<ul class="tree" ng-repeat="item in related | limitTo:6 " id="tree">
         {{title}}
	<li>
	{{item.name}}
    <a ui-sref="ad_tab({id:89})">{{item.name}}</a></li>
            <table>
            <ul class="last" ng-repeat="x in item.field">
                         
            	 <li class="file"> {{x.name}} {{x.columnname}}</li>
            	 
            </ul>
	         </table>
</li>