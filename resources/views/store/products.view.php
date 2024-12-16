<?php
$productsList = $products ?? [];
?>

<header class="bg-blue-600 text-white py-4">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">Tienda de Productos</h1>
    <div id="cart" class="bg-white text-black p-4 rounded-lg shadow">
      <h2 class="text-lg font-bold mb-2">Carrito</h2>
      <ul id="cart-items" class="mb-4"></ul>
      <p class="font-bold">Total: <span id="cart-total">S/ 0.00</span></p>
    </div>
  </div>
</header>

<div class="flex justify-between">
  <button onclick="clearCart()" class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-700">Limpiar Carrito</button>
  <button onclick="window.location.href = '/cart'" class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-700">Ir al Carrito</button>
</div>

<h2 class="text-3xl font-bold mb-6">Productos</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
  <?php foreach ($productsList as $product): ?>
    <div class="bg-white p-4 rounded-lg shadow">
      <h3 class="text-lg font-bold"><?= $product['name'] ?></h3>
      <p class="text-gray-600">S/ <?= number_format($product['price'], 2) ?></p>
      <button class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-700" onclick="addToCart(<?= $product['id'] ?>)">
        Agregar al Carrito
      </button>
    </div>
  <?php endforeach; ?>
</div>


<script>
  async function clearCart() {
    axios.post('/api/cart/clear', { action: 'clear' })
      .then(response => {
        updateCartView(response.data);
      })
      .catch(error => console.error(error));
  }

  async function loadCart() {
    axios.post('/api/cart', { action: 'list' })
      .then(response => {
        updateCartView(response.data);
      })
      .catch(error => console.error(error));
  }

  async function addToCart(productId) {
    axios.post('/api/cart', { productId, action: 'add' })
      .then(response => {
        updateCartView(response.data);
      })
      .catch(error => console.error(error));
  }

  function updateCartView(cart) {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    if (!cart.items || cart.items.length === 0) {
      cartItems.innerHTML = '<li>No hay productos en el carrito</li>';
    } else {
      cartItems.innerHTML = cart.items.map(item =>
        `<li class="flex justify-between items-center">
                      <span>${item.name} (x${item.quantity})</span>
                      <span>S/ ${item.total.toFixed(2)}</span>
                  </li>`
      ).join('');
    }
    cartTotal.textContent = `S/ ${cart.total.toFixed(2)}`;
  }
  window.onload = loadCart;
</script>