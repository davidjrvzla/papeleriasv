    <?php 
$categories = CategoryData::getAll();
    ?>
<div class="row">
	<div class="col-md-12">
    
    <?php if (isset($_GET["codigo"])): ?>
    <p class='alert alert-danger'>¡El <b>Codigo de Barra</b> ya esta en uso!</p>
    <?php endif; ?>

	<h1>Nuevo Producto</h1>
	<br>
		<form class="form-horizontal" method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=addproduct" role="form">

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Codigo de Barras*</label>
    <div class="col-md-6">
      <input type="text" name="barcode" id="product_code" class="form-control" id="barcode" placeholder="Codigo de Barras del Producto" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Categoria</label>
    <div class="col-md-6">
    <select name="category_id" class="form-control">
    <option value="">-- NINGUNA --</option>
    <?php foreach($categories as $category):?>
      <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
    <?php endforeach;?>
      </select>    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Precio de Entrada*</label>
    <div class="col-md-6">
      <input type="number" min="1" name="price_in" required class="form-control" id="price_in" placeholder="Precio de entrada">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Precio de Salida*</label>
    <div class="col-md-6">
      <input type="number" min="1" name="price_out" required class="form-control" id="price_out" placeholder="Precio de salida">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Minima en inventario*</label>
    <div class="col-md-6">
      <input type="number" min="1" name="inventary_min" required class="form-control" id="inputEmail1" placeholder="Minima en Inventario">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Inventario inicial:</label>
    <div class="col-md-6">
      <input type="number" min="1" name="q" class="form-control" id="inputEmail1" placeholder="Inventario inicial">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </div>
  </div>
</form>

	</div>
</div>

<script>
  $(document).ready(function(){


    $("#product_code").keydown(function(e){
        if(e.which==17 || e.which==74 ){
            e.preventDefault();
        }else{
            console.log(e.which);
        }
    })

    $("#addproduct").submit(function(e) {

      // Inicio de validacion de precios
      var pIn = Number($("#price_in").val());
      var pOut = Number($("#price_out").val());
      if (pIn > pOut) {
        alert('El precio de salida debe ser mayor que el precio de entrada');
        e.preventDefault();
        return false;
      }
    });
    // Fin de validacion de precios
});

</script>