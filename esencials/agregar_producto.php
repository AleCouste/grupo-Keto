<div class="container mt-4">
  <h2>Agregar Producto</h2>
  <form action="insertar_producto.php" method="POST">
    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Descripcion</label>
      <input type="text" name="descripcion" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>URL de Imagen</label>
      <textarea name="imagen" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label>Precio</label>
      <input type="number" step="0.01" name="precio" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Categoria</label>
      <input type="text" name="categoria" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </form>
</div>
