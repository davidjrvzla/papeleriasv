<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
	<a href="index.php?view=newcategory" class="btn btn-default"><i class='fa fa-th-list'></i> Nueva Categoria</a>
</div>
		<h1>Categorias</h1>
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

		$users = CategoryData::getAll();
		if(count($users)>0){

			// Validaciones para paginar
			if($page==1){

				$curr_products = CategoryData::getAllByPage($users[0]->id,$limit);
				// print_r($curr_products);
				// exit();
			}
			else {
				// print_r('($page-1)*$limit: ' . $products[($page-1)*$limit]->id. " hasta: ".$limit);
				// exit();

				$curr_products = CategoryData::getAllByPage($users[($page-1)*$limit]->id,$limit);
			}

			$npaginas = floor(count($users)/$limit);
			$spaginas = count($users)%$limit;

			if($spaginas>0) { 
				$npaginas++;
			}	

			// fin de validaciones
			// si hay usuarios
			?>

			<table class="table table-bordered table-hover">
				<thead>
					<th>Nombre</th>
					<th></th>
				</thead>
				<?php foreach($curr_products as $user):?>
				<tr>
					<td><?php echo $user->name." ".$user->lastname; ?></td>
					<td style="width:70px;">
						<a href="index.php?view=editcategory&id=<?php echo $user->id;?>" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
						<a href="index.php?view=delcategory&id=<?php echo $user->id;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<?php endforeach;?>
			</table>

			<div class="btn-group pull-right">
			<?php

			for($i=0;$i<$npaginas;$i++){
				echo "<a href='index.php?view=categories&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a>";
			}
			?>
			</div>
			<form class="form-inline">
				<label for="limit">Limite</label>
				<input type="hidden" name="view" value="categories">
				<input type="number" min="1" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
			</form>
				<?php
			}else{
				echo "<p class='alert alert-danger'>No hay Categorias</p>";
			}

			?>
		<br><br>
	</div>
</div>