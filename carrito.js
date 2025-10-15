function Toast(cantidad, nombre) {
    Toastify({
        text: `✅ Se agregaron ${cantidad} unidad${cantidad > 1 ? 'es' : ''} de "${nombre}" al carrito`,
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "#4CAF50",
        close: true
    }).showToast();
}

function agregarAlCarrito(producto) {
    console.log("📦 Agregando producto:", producto);

    if (!producto || !producto.id || !producto.precio) {
        console.error("❌ Producto inválido:", producto);
        return;
    }

    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const cantidadAGregar = producto.cantidad ? parseInt(producto.cantidad) : 1;

    let existente = carrito.find(p => p.id == producto.id);

    if (existente) {
        existente.cantidad += cantidadAGregar;
    } else {
        carrito.push({
            id: producto.id,
            nombre: producto.nombre,
            precio: producto.precio,
            cantidad: cantidadAGregar
        });
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));
    console.log("✅ Carrito actualizado:", carrito);

    // Mostrar toast con la cantidad exacta
    Toast(cantidadAGregar, producto.nombre);
}

function actualizarContadorCarrito() {
  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
  document.getElementById('carrito-count').textContent = `(${carrito.length})`;
}

let stockDisponible = 0; // Se asignará dinámicamente desde PHP

function cambiarCantidad(delta) {
  const input = document.getElementById("cantidad");
  let cantidad = parseInt(input.value);
  cantidad += delta;

  if (cantidad < 1) cantidad = 1;

  if (cantidad > stockDisponible) {
    cantidad = stockDisponible;

    Toastify({
      text: "No hay más stock disponible",
      duration: 2500,
      gravity: "top",
      position: "right",
      backgroundColor: "#f44336",
      close: true
    }).showToast();
  }

  input.value = cantidad;
}

function limpiarCarrito() {
  // Vaciar carrito en localStorage
  localStorage.removeItem("carrito");

  // Actualizar el numerito del carrito
  actualizarContadorCarrito();

  // Si estamos en la página del carrito, refrescar la vista
  if (document.getElementById("lista-carrito")) {
    document.getElementById("lista-carrito").innerHTML = "<li class='list-group-item'>El carrito está vacío</li>";
    document.getElementById("total").textContent = "";
  }

  console.log("🧹 Carrito limpiado");
}


document.addEventListener('DOMContentLoaded', actualizarContadorCarrito);
