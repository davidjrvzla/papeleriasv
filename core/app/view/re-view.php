<div class="row">
	<div class="col-md-12">
		<h1>Reabastecer Inventario</h1>
		<p><b>Buscar producto por nombre:</b></p>
		<form>
			<div class="row">
				<div class="col-md-6">
					<input type="hidden" name="view" value="re">
					<input type="text" name="product" class="form-control">
				</div>
				<div class="col-md-3">
					<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
				</div>
			</div>
		</form>
		<?php if(isset($_GET["product"])):?>
			<?php
		$products = ProductData::getLike($_GET["product"]);
		if(count($products)>0){
			?>
		<h3>Resultados de la Busqueda</h3>
		<table class="table table-bordered table-hover">
			<thead>
				<th>Codigo</th>
				<th>Nombre</th>
				<th>Precio unitario</th>
				<th>En inventario</th>
				<th>Cantidad</th>
				<th style="width:100px;"></th>
			</thead>
			<?php
		$products_in_cero=0;
			 foreach($products as $product):
		$q= OperationData::getQYesF($product->id);
			?>
				<form method="post" action="index.php?view=addtore">
			<tr class="<?php if($q<=$product->inventary_min){ echo "danger"; }?>">
				<td style="width:80px;"><?php echo $product->barcode; ?></td>
				<td><?php echo $product->name; ?></td>
				<td><b><?php echo number_format($product->price_in,2,'.',','); ?> Bs</b></td>
				<td>
					<?php echo $q; ?>
				</td>
				<td>
				<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
				<input type="number" min="1" class="form-control" required name="q" placeholder="Cantidad"></td>
				<td style="width:100px;">
				<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
				</td>
			</tr>
			</form>
			<?php endforeach;?>
		</table>

			<?php
		}
		?>
		
		<?php else:
		?>

		<?php endif; ?>

		<?php if(isset($_SESSION["errors"])):?>
		<h2>Errores</h2>
		<p></p>
		<table class="table table-bordered table-hover">
		<tr class="danger">
			<th>Codigo</th>
			<th>Producto</th>
			<th>Mensaje</th>
		</tr>
		<?php foreach ($_SESSION["errors"]  as $error):
		$product = ProductData::getById($error["product_id"]);
		?>
		<tr class="danger">
			<td><?php echo $product->id; ?></td>
			<td><?php echo $product->name; ?></td>
			<td><b><?php echo $error["message"]; ?></b></td>
		</tr>

		<?php endforeach; ?>
		</table>
		<?php
		unset($_SESSION["errors"]);
		 endif; ?>


		<!--- Carrito de compras :) -->
		<?php if(isset($_SESSION["reabastecer"])):
		$total = 0;
		?>
		<h2>Lista de Reabastecimiento</h2>
		<table class="table table-bordered table-hover">
		<thead>
			<th style="width:30px;">Codigo</th>
			<th style="width:30px;">Producto</th>
			<th style="width:30px;">Cantidad</th>
			<th style="width:30px;">Precio Unitario</th>
			<th style="width:30px;">Precio Total</th>
			<th ></th>
		</thead>
		<?php foreach($_SESSION["reabastecer"] as $p):
		$product = ProductData::getById($p["product_id"]);
		?>
		<tr >
			<td><?php echo $product->barcode; ?></td>
			<td><?php echo $product->name; ?></td>
			<td ><?php echo $p["q"]; ?></td>
			<td><b><?php echo number_format($product->price_in); ?>.00 Bs</b></td>
			<td><b><?php  $pt = $product->price_in*$p["q"]; $total +=$pt; echo number_format($pt); ?>.00 Bs</b></td>
			<td style="width:30px;"><a href="index.php?view=clearre&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
		</tr>

		<?php endforeach; ?>
		</table>
		<form method="post" class="form-horizontal" id="processsell" action="index.php?view=processre">
		<div class="form-group">
		    <label for="inputEmail1" class="col-lg-2 control-label"><h3>Proveedor</h3></label>
		    <div class="col-lg-10">
		    <?php 
		$clients = PersonData::getProviders();
		    ?>
		    <select name="client_id" class="form-control">
		    <option value="">-- NINGUNO --</option>
		    <?php foreach($clients as $client):?>
		    	<option value="<?php echo $client->id;?>"><?php echo $client->name." ".$client->lastname;?></option>
		    <?php endforeach;?>
		    	</select>
		    </div>
		  </div>

		  <div class="row">
		<div class="col-md-6 col-md-offset-6">
		<table class="table table-bordered">
			
		<tr>
			<td><h1>Total</h1></td>
			<td><h1><b><?php echo number_format($total); ?>.00 Bs</b></h1></td>
		</tr>

		</table>
		  
		<div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <div class="checkbox">
		        <label>
				<a href="index.php?view=clearre" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
		        <button class="btn btn-lg btn-primary"><i class="fa fa-refresh"></i> Procesar Reabastecimiento</button>
		        </label>
		      </div>
		    </div>
		  </div>
		</form>
		<script>
			$("#processsell").submit(function(e){
				money = $("#money").val();
				if(money<<?php echo $total;?>){
					alert("No se puede efectuar la operacion");
					e.preventDefault();
				}else{
					//go = confirm("Procesar Reabastecimiento");
					if(go){}
						else{e.preventDefault();}
				}
			});
		</script>
		</div>
		</div>

		<br><br>
		<?php endif; ?>
	</div>
</div>