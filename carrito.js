function agregarAlCarrito(id) {
  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
  carrito.push(id);
  localStorage.setItem('carrito', JSON.stringify(carrito));
  actualizarContadorCarrito();
}

function actualizarContadorCarrito() {
  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
  document.getElementById('carrito-count').textContent = `(${carrito.length})`;
}

document.addEventListener('DOMContentLoaded', actualizarContadorCarrito);
