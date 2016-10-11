<felmenu></felmenu>
<md-card>
<md-card md-theme="dark-purple">
  
  <div class="md-toolbar-tools">
    <span>{{title}}</span>
    {{related.count}}
    
  </div>
<md-table-container>
  <table md-table md-row-select multiple ng-model="selected" md-progress="promise">
    <thead md-head md-order="query.order" md-on-reorder="getDesserts">
      <tr md-row>
        <th md-column md-order-by="nameToLower"><span>id</span></th>
        <th md-column md-numeric md-order-by="calories.value"><span>name</span></th>
        <th md-column md-numeric>Value</th>
        <th md-column md-numeric>Class</th>
        <th md-column md-numeric>Protein (g)</th>
        <th md-column md-numeric>Sodium (mg)</th>
        <th md-column md-numeric>Calcium (%)</th>
        <th md-column md-numeric>Iron (%)</th>
      </tr>
    </thead>
    <tbody md-body>

      <tr md-row md-select="dessert" md-select-id="name" md-auto-select ng-repeat="dessert in related">
        <td md-cell>{{dessert.id}}</td>
        <td md-cell>{{dessert.name}}</td>
        <td md-cell>{{dessert.value}}</td>
        <td md-cell>{{dessert}}</td>
        <td md-cell>{{dessert.protein.value | number: 1}}</td>
        <td md-cell>{{dessert.sodium.value}}</td>
        <td md-cell>{{dessert.calcium.value}}{{dessert.calcium.unit}}</td>
        <td md-cell>{{dessert.iron.value}}{{dessert.iron.unit}}</td>
      </tr>
    </tbody>
  </table>
</md-table-container>

<md-table-pagination md-limit="4" md-limit-options="[5, 10, 15]" md-page="4" md-total="{{10}}" md-on-paginate="getDesserts" md-page-select></md-table-pagination>


   <md-card-content>


</md-card>


   