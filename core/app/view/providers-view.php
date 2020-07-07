<?php
$page = 1;
if(isset($_GET["page"])){
	$page=$_GET["page"];
}

$limit=10;
if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
	$limit=$_GET["limit"];
}

//$users = PersonData::getAll();
$users = PersonData::getProviders();
?>

<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
	<a href="index.php?view=newprovider" class="btn btn-default"><i class='fa fa-truck'></i> Nuevo Proveedor</a>
<?php if(count($users)>0) { ?>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/providers-word.php">Word (.docx)</a></li>
  </ul>
</div>
<?php }?>
</div>
		<h1>Directorio de Proveedores</h1>
		<br>
		<?php

		
	
	$page = 1;
	if(isset($_GET["page"])){
		$page=$_GET["page"];
	}
	$limit=10;
	if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
		$limit=$_GET["limit"];
	}

	//$users = PersonData::getAll();
	$users = PersonData::getProviders();
		
	if(count($users)>0){

		// Validaciones para paginar
		if($page==1){

			$curr_products = PersonData::getAllProvidersByPage($users[0]->id,$limit);
		}
		else {
			$curr_products = PersonData::getAllProvidersByPage($users[($page-1)*$limit]->id,$limit);
		}

		$npaginas = floor(count($users)/$limit);
		$spaginas = count($users)%$limit;

		if($spaginas>0) { 
			$npaginas++;
		}
		// fin de validaciones
?>

<table class="table table-bordered table-hover">
	<thead>
		<th>Nombre completo</th>
		<th>Direccion</th>
		<th>Email</th>
		<th>Telefono</th>
		<th></th>
	</thead>
	<?php foreach($curr_products as $user):?>
	<tr>
		<td><?php echo $user->name." ".$user->lastname; ?></td>
		<td><?php echo $user->address1; ?></td>
		<td><?php echo $user->email1; ?></td>
		<td><?php echo $user->phone1; ?></td>
		<td style="width:70px;">
			<a href="index.php?view=editprovider&id=<?php echo $user->id;?>" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
			<a href="index.php?view=delprovider&id=<?php echo $user->id;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
		</td>
	</tr>
	<?php endforeach;?>
</table>

<div class="btn-group pull-right">
	<?php
	for($i=0;$i<$npaginas;$i++){
		echo "<a href='index.php?view=providers&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a>";
	}
	?>
</div>

<form class="form-inline">
	<label for="limit">Limite</label>
	<input type="hidden" name="view" value="providers">
	<input type="number" min="1" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
</form>
<?php
	}else{
		echo "<p class='alert alert-danger'>No hay Proveedores</p>";
	}

?>
		<br><br>
	</div>
</div>