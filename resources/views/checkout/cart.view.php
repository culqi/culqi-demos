<?php
// Inicia la sesión
session_start();

$cart = $_SESSION['cart'];

$total = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
?>

<div class="container mx-auto mt-10">
  <h1 class="text-2xl font-bold mb-5">Carrito de Compras</h1>

  <div class="bg-white shadow-md rounded-lg p-5">
    <table class="w-full text-left border-collapse">
      <thead>
        <tr>
          <th class="border-b py-2">Producto</th>
          <th class="border-b py-2">Precio</th>
          <th class="border-b py-2">Cantidad</th>
          <th class="border-b py-2">Subtotal</th>
          <th class="border-b py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart as $item): ?>
          <tr>
            <td class="py-2"><?= htmlspecialchars($item['name']) ?></td>
            <td class="py-2">$<?= number_format($item['price'], 2) ?></td>
            <td class="py-2">
              <div class="flex items-center">
                <?= htmlspecialchars($item['quantity']) ?>
                <button class="ml-2 px-2 py-1 bg-blue-500 text-white rounded" onclick="updateQuantity(<?= $item['id'] ?>, 1)">+</button>
                <?php
                if ($item['quantity'] > 1): ?>
                  <button class="ml-2 px-3 py-1 bg-blue-500 text-white rounded" onclick="updateQuantity(<?= $item['id'] ?>, 1, false)">-</button>
                <?php endif; ?>
              </div>
            </td>
            <td class="py-2">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            <td class="py-2">
              <button class="px-4 py-2 bg-red-500 text-white rounded" onclick="removeItem(<?= $item['id'] ?>)">Eliminar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="mt-5 text-right">
      <p class="text-lg font-semibold">Total: $<?= number_format($total, 2) ?></p>
      <div class="flex justify-between">
        <button onclick="window.location.href = '/store'" class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-700 h-10">Seguir comprando</button>
        <div>
          <button class="mt-3 px-5 py-2 bg-green-500 text-white rounded" onclick="payCart()">Pagar</button>
          <?php if (count($cart) > 0): ?>
            <button class="mt-3 px-5 py-2 bg-red-500 text-white rounded" onclick="clearCart()">Vaciar Carrito</button>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  function updateQuantity(productId, change, isIncrement = true) {
    axios.put(`/api/cart/${productId}`, { quantity: change, isIncrement })
      .then(response => window.location.reload())
      .catch(error => console.error(error));
  }
  async function loadCart() {
    axios.post('/api/cart', { action: 'list' })
      .catch(error => console.error(error));
  }
  function removeItem(productId) {
    axios.delete(`/api/cart/${productId}`)
      .then(response => window.location.reload())
      .catch(error => console.error(error));
  }

  function clearCart() {
    axios.post('/api/cart', { action: 'clear' })
      .then(response => window.location.reload())
      .catch(error => console.error(error));
  }

  function payCart() {
    alert('Redirigiendo a la página de pago...');
  }
  window.onload = loadCart;

</script>