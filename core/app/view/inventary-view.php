<?php
$page = 1;
if(isset($_GET["page"])){
	$page=$_GET["page"];
}

$limit=10;
if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
	$limit=$_GET["limit"];
}

$products = ProductData::getAll();
?>
<div class="row">
	<div class="col-md-12">
<!-- Single button -->
<?php if(count($products)>0) { ?>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/inventary-word.php">Word (.docx)</a></li>
  </ul>
</div>
<?php }?>
		<h1><i class="glyphicon glyphicon-stats"></i> Inventario de Productos</h1>
		<br>
		<div class="clearfix"></div>


<?php
$page = 1;
if(isset($_GET["page"])){
	$page=$_GET["page"];
}
$limit=10;
if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
	$limit=$_GET["limit"];
}
$products = ProductData::getAll();
if(count($products)>0){

if($page==1){
$curr_products = ProductData::getAllByPage($products[0]->id,$limit);
}else{
$curr_products = ProductData::getAllByPage($products[($page-1)*$limit]->id,$limit);

}
$npaginas = floor(count($products)/$limit);
 $spaginas = count($products)%$limit;

if($spaginas>0){ 
	$npaginas++;
}

?>

<div class="clearfix"></div>
<br><table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Disponible</th>
		<th></th>
	</thead>
	<?php foreach($curr_products as $product):
	$q=OperationData::getQYesF($product->id);
	?>
	<tr class="<?php if($q<=$product->inventary_min/2){ echo "danger";}else if($q<=$product->inventary_min){ echo "warning";}?>">
		<td><?php echo $product->barcode; ?></td>
		<td><?php echo $product->name; ?></td>
		<td>
			
			<?php echo $q; ?>

		</td>
		<td style="width:93px;">
<!--		<a href="index.php?view=input&product_id=<?php echo $product->id; ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-circle-arrow-up"></i> Alta</a>-->
		<a href="index.php?view=history&product_id=<?php echo $product->id; ?>" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-time"></i> Historial</a>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div class="btn-group pull-right">
<?php

for($i=0;$i<$npaginas;$i++){
	echo "<a href='index.php?view=inventary&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
}
?>
</div>
<form class="form-inline">
	<label for="limit">Limite</label>
	<input type="hidden" name="view" value="inventary">
	<input type="number" min="1" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
</form>

<div class="clearfix"></div>

	<?php
}else{
	echo "<p class='alert alert-danger'>No hay Productos</p>";
}

?>
<br><br>
	</div>
</div>