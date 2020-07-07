<?php
	$found=true;
  $products = ProductData::getAll();
  foreach($products as $product){
  	$q=OperationData::getQYesF($product->id);	
  	if($q<=$product->inventary_min){
  		$found=true;
  		break;
  	}
  }
?>



<div class="row">
	<div class="col-md-12">
		<h1>Bienvenido a Papeleria San Vicente</h1>
  </div>
</div>
  <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo count(ProductData::getAll());?></h3>

              <p>Productos</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="./?view=products" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php echo count(PersonData::getClients());?></h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="./?view=clients" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <?php if (UserData::getById($_SESSION["user_id"])->is_admin==1): ?>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo count(PersonData::getProviders());?></h3>

              <p>Proveedores</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="./?view=providers" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <?php endif; ?>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo count(CategoryData::getAll());?></h3>

              <p>Categorias</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="./?view=categories" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

<div class="row">
	<div class="col-md-12">
<?php if($found):?>

<?php endif;?>

</div>
<div class="clearfix"></div>
<?php 

  if(count($products)>0) {

   $new_list = array();
  foreach($products as $product) {
    $q=OperationData::getQYesF($product->id);
    if($q<=$product->inventary_min) {
      $new_list[] = $product;
    }
  }

  if (count($new_list) > 0) {
    // Existen productos con alerta
    $products = $new_list;
    //print_r($products);
   // exit();  
  }
  else {
    $products = array();
  }

  if ( count($products) > 0) {
?>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/alerts-word.php">Word (.docx)</a></li>
  </ul>
</div>
<br><table class="table table-bordered table-hover">
	<thead>
		<th >Codigo</th>
		<th>Nombre del producto</th>
		<th>En Stock</th>
		<th></th>
	</thead>
	<?php
foreach($products as $product) {
	$q=OperationData::getQYesF($product->id);
	?>
	
	<tr class="<?php if($q==0){ echo "danger"; } else if($q<=$product->inventary_min/2){ echo "danger"; } else if($q<=$product->inventary_min){ echo "warning"; } ?>">
		<td><?php echo $product->barcode; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><?php echo $q; ?></td>
		<td>
		<?php 

    if($q==0){ 
      echo "<span class='label label-danger'>No hay existencias.</span>";
    }
    else if($q<=$product->inventary_min/2) { 
      echo "<span class='label label-danger'>Quedan muy pocas existencias.</span>";
    } 
    else if($q<=$product->inventary_min){
     echo "<span class='label label-warning'>Quedan pocas existencias.</span>";
   } 
   ?>
		</td>
	</tr>
<?php } ?>
</table>
<?php } 
}
?>
<div class="clearfix"></div>

	<br><br><br>
	</div>
</div>