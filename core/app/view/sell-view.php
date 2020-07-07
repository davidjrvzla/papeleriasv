<div class="row">
	<div class="col-md-12">
		<h1>Venta</h1>
		<p><b>Buscar producto por nombre:</b></p>
		<form id="searchp">
			<div class="row">
				<div class="col-md-6">
					<input type="hidden" name="view" value="sell">
					<input type="text" id="product_code" name="product" class="form-control">
				</div>
				<div class="col-md-3">
					<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
				</div>
			</div>
		</form>
		<div id="show_search_results"></div>
		<script> 
		//jQuery.noConflict();

		$(document).ready(function(){
			$("#searchp").on("submit",function(e){
				e.preventDefault();
				
				$.get("./?action=searchproduct",$("#searchp").serialize(),function(data){
					$("#show_search_results").html(data);
				});
				$("#product_code").val("");

			});
			});

		$(document).ready(function(){
		    $("#product_code").keydown(function(e){
		        if(e.which==17 || e.which==74){
		            e.preventDefault();
		        }else{
		            console.log(e.which);
		        }
		    })
		});
		</script>

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
			<td><?php echo $product->barcode; ?></td>
			<td><?php echo $product->name; ?></td>
			<td><b><?php echo $error["message"]; ?></b></td>
		</tr>

		<?php endforeach; ?>
		</table>
		<?php
		unset($_SESSION["errors"]);
		 endif; ?>


		<!--- Carrito de compras :) -->
		<?php if(isset($_SESSION["cart"])):
		$total = 0;
		?>
		<h2>Lista de venta</h2>
		<table class="table table-bordered table-hover">
		<thead>
			<th style="width:30px;">Codigo</th>
			<th style="width:30px;">Producto</th>
			<th style="width:30px;">Cantidad</th>
			<th style="width:30px;">Precio Unitario</th>
			<th style="width:30px;">Precio Total</th>
			<th ></th>
		</thead>
		<?php foreach($_SESSION["cart"] as $p):
		$product = ProductData::getById($p["product_id"]);
		?>
		<tr >
			<td><?php echo $product->barcode; ?></td>
			<td><?php echo $product->name; ?></td>
			<td ><?php echo $p["q"]; ?></td>
			<td><b><?php echo number_format($product->price_out); ?>.00 Bs</b></td>
			<td><b><?php  $pt = $product->price_out*$p["q"]; $total +=$pt; echo number_format($pt); ?>.00 Bs</b></td>
			<td style="width:30px;"><a href="index.php?view=clearcart&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
		</tr>

		<?php endforeach; ?>
		</table>
		<form method="post" class="form-horizontal" id="processsell" action="index.php?view=processsell">
		<div class="form-group">
		    <label for="inputEmail1" class="col-lg-2 control-label"><h3>Cliente</h3></label>
		    <div class="col-lg-10">
		    <?php 
		$clients = PersonData::getClients();
		    ?>
		    <select name="client_id" class="form-control">
		    <option value="">-- NINGUNO --</option>
		    <?php foreach($clients as $client):?>
		    	<option value="<?php echo $client->id;?>"><?php echo $client->name." ".$client->lastname;?></option>
		    <?php endforeach;?>
		    	</select>
		    </div>
		  </div>
		 
		      <input type="hidden" name="total" value="<?php echo $total; ?>" class="form-control" placeholder="Total">

		  <div class="row">
		<div class="col-md-6 col-md-offset-6">
		<table class="table table-bordered">
		<tr>
			<td><p>Subtotal</p></td>
			<td><p><b><?php echo number_format($total*.835); ?> Bs</b></p></td>
		</tr>
		<tr>
			<td><p>IVA</p></td>
			<td><p><b><?php echo number_format($total*.165); ?> Bs</b></p></td>
		</tr>
		<tr>
			<td><h1>Total</h1></td>
			<td><h1><b><?php echo number_format($total); ?>.00 Bs</b></h1></td>
		</tr>

		</table>
		<div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <div class="checkbox">
		        <label>
				<a href="index.php?view=clearcart" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
		        <button class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-ok"></i> Finalizar Venta</button>
		        </label>
		      </div>
		    </div>
		  </div>
		</form>
		<script>
			$("#processsell").submit(function(e){
				money = $("#money").val();
				if(money<(<?php echo $total;?>)){
					alert("No se puede efectuar la operacion");
					e.preventDefault();
				}else{
					//go = confirm("Finalizar venta");
					if(go){

					}else{
						e.preventDefault();
					}
				}
			});
		</script>
		</div>
		</div>

		<br><br>
		<?php endif; ?>
	</div>
</div>