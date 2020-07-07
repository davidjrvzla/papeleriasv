<div class="row">
	<div class="col-md-12">
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Reabastecimientos</h1>
		<br>
		<div class="clearfix"></div>


<?php

// Se calcula el dato del numo de la pagina en la variable $page
$page = 1;
if(isset($_GET["page"])){
	$page=$_GET["page"];
}
$limit=10;
if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
	$limit=$_GET["limit"];
}

$products = SellData::getRes();


if(count($products)>0){
	// Validaciones para paginar
	if($page==1){

		$curr_products = SellData::getAllResByPage($products[0]->id,$limit);
		// print_r($curr_products);
		// exit();
	}
	else {
		// print_r('($page-1)*$limit: ' . $products[($page-1)*$limit]->id. " hasta: ".$limit);
		// exit();

		$curr_products = SellData::getAllResByPage($products[($page-1)*$limit]->id,$limit);
	}

	$npaginas = floor(count($products)/$limit);
	$spaginas = count($products)%$limit;

	if($spaginas>0) { 
		$npaginas++;
	}	

	// fin de validaciones
	?>
<br>
<table class="table table-bordered table-hover	">
	<thead>
		<th></th>
		<th>Fecha</th>
		<th>Total</th>
		<th></th>
	</thead>
	<?php foreach($curr_products as $sell):?>

	<tr>
		<!--Visualizar-->
		<td style="width:30px;">
			<a href="index.php?view=onere&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
		</td>
		<!--Visualizar-->

		<!--Fecha-->
		<td><?php echo $sell->created_at; ?></td>
		<!--Fecha-->
		
		<!--Total-->
		<td>
		<?php
		$operations = OperationData::getAllProductsBySellId($sell->id);
		$total=0;
			foreach($operations as $operation){
				$product  = $operation->getProduct();
				$total += $operation->q*$operation->price;
			}
				echo "<b>".number_format($total).".00 Bs</b>";

		?>			
		</td>
		<!--Total-->
		
		<!--Eliminar-->
		<?php if (UserData::getById($_SESSION["user_id"])->is_admin==1): ?>
		<td style="width:30px;">
			<a href="index.php?view=delre&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
		</td>
		<?php endif; ?>
		<!--Eliminar-->
	</tr>

<?php endforeach; ?>

</table>
<!-- Controles de navegacion entre paginas -->
	<div class="btn-group pull-right">
	<?php

	for($i=0;$i<$npaginas;$i++){
		echo "<a href='index.php?view=res&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
	}
	?>
	</div>
	<form class="form-inline">
		<label for="limit">Limite</label>
		<input type="hidden" name="view" value="res">
		<input type="number" min="1" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
	</form>

	<div class="clearfix"></div>
<!-- Fin de controles -->
	<?php
}else{
	echo "<p class='alert alert-danger'>No hay Reabastecimientos</p>";
}

?>
<br><br>
	</div>
</div>