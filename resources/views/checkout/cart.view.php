<?php

use App\Config\Config;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cart = $_SESSION['cart'];

$total = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

$constants = [
    'baseURL' =>   Config::API_BASE_URL,
    'customer_code' => $_SESSION['user']['customer']['customer_code'] ?? 'cus_empty',
    'secret_key' => Config::SECRET_KEY ?? 'empty',
    'public_key' => Config::PUBLIC_KEY ?? 'empty',
    'amount' => $total * 100,
    'currency' => 'PEN',
];


?>

<div class="container" bis_skin_checked="1">
    <div class="mb-4" bis_skin_checked="1">
        <h1 class="text-center">Cart</h1>
    </div>
    <div class="mb-10 cart-table" bis_skin_checked="1">
        <form class="mb-4" action="#" method="post">
            <table class="table" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name">Product</th>
                        <th class="product-price">Precio</th>
                        <th class="product-quantity w-lg-15">Cantidad</th>
                        <th class="product-subtotal">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                        <tr class="">
                            <td class="text-center">
                                <a href="javascript:;" class="text-gray-32 font-size-26" onclick="removeItem(<?= $item['id'] ?>)">×</a>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <a href="javascript:;"><img class="img-fluid max-width-100 p-1 border border-color-1"
                                        src="<?= htmlspecialchars($item['image']) ?>" alt="Image Description"></a>
                            </td>

                            <td data-title="Product">
                                <a href="javascript:;" class="text-gray-90"><?= htmlspecialchars($item['name']) ?></a>
                            </td>

                            <td data-title="Price">
                                <span class="">S/ <?= number_format($item['price'], 2) ?></span>
                            </td>

                            <td data-title="Quantity">
                                <span class="sr-only">Cantidad</span>
                                <!-- Quantity -->
                                <div class="border rounded-pill py-1 width-122 w-xl-80 px-3 border-color-1" bis_skin_checked="1">
                                    <div class="js-quantity row align-items-center" bis_skin_checked="1">
                                        <div class="col" bis_skin_checked="1">
                                            <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text"
                                                value="<?= $item['quantity'] ?>" bis_skin_checked="1" readonly>
                                        </div>
                                        <div class="col-auto pr-1" bis_skin_checked="1">
                                            <a class="js-minus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0"
                                                onclick="updateQuantity(<?= $item['id'] ?>, 1, false, <?= $item['quantity'] ?>)" href="javascript:;">
                                                <small class="fas fa-minus btn-icon__inner"></small>
                                            </a>
                                            <a class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0"
                                                onclick="updateQuantity(<?= $item['id'] ?>, 1, true, <?= $item['quantity'] ?>)" href="javascript:;">
                                                <small class="fas fa-plus btn-icon__inner"></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Quantity -->
                            </td>

                            <td data-title="Total">
                                <span class="">S/ <?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" class="border-top space-top-2 justify-content-center">
                            <div class="pt-md-3" bis_skin_checked="1">
                                <div class="d-block d-md-flex flex-center-between" bis_skin_checked="1">
                                    <?php if (count($cart) > 0): ?>
                                        <div class="mb-3 mb-md-0 w-xl-40" bis_skin_checked="1">
                                            <!-- Apply coupon Form -->

                                            <label class="sr-only" for="subscribeSrEmailExample1">Coupon code</label>
                                            <div class="input-group" bis_skin_checked="1">
                                                <input type="text" class="form-control" name="text" id="subscribeSrEmailExample1"
                                                    placeholder="Coupon code" aria-label="Coupon code" aria-describedby="subscribeButtonExample2"
                                                    required="">
                                                <div class="input-group-append" bis_skin_checked="1">
                                                    <button class="btn btn-block btn-dark px-4" type="button" id="subscribeButtonExample2"><i
                                                            class="fas fa-tags d-md-none"></i><span class="d-none d-md-inline">Apply
                                                            coupon</span></button>
                                                </div>
                                            </div>

                                            <!-- End Apply coupon Form -->
                                        </div>
                                        <div class="d-md-flex" bis_skin_checked="1">
                                            <button type="button"
                                                class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto"
                                                onclick="clearCart()">Vaciar Carrito</button>


                                            <a href="/checkout"
                                                class="btn btn-primary shadow-none text-white ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block">Proceder
                                                con el pago</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php if (count($cart) === 0): ?>
                <h2>Carrito Vacio</h2>
            <?php endif; ?>
        </form>
    </div>
    <?php if (count($cart) > 0): ?>
        <div class="mb-8 cart-total" bis_skin_checked="1">
            <div class="row" bis_skin_checked="1">
                <div class="col-xl-5 col-lg-6 offset-lg-6 offset-xl-7 col-md-8 offset-md-4" bis_skin_checked="1">
                    <div class="border-bottom border-color-1 mb-3" bis_skin_checked="1">
                        <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Cart totals</h3>
                    </div>
                    <table class="table mb-3 mb-md-0">
                        <tbody>
                            <tr class="order-total">
                                <th class="amount font-size-22">Total</th>
                                <td data-title="Total"><strong><span class="amount font-size-22">S/ <?= number_format($total, 2) ?></span></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function updateQuantity(productId, change, isIncrement = true, quantity) {
        console.log(quantity);

        if (isIncrement === false && quantity <= 1) {
            removeItem(productId);
        } else {
            axios.put(`/api/cart/${productId}`, {
                    quantity: change,
                    isIncrement
                })
                .then(response => window.location.reload())
                .catch(error => console.error(error));
        }
    }

    function removeItem(productId) {
        axios.delete(`/api/cart/${productId}`)
            .then(response => window.location.reload())
            .catch(error => console.error(error));
    }


    async function clearCart() {
        axios.post('/api/cart/clear', {
                action: 'clear'
            })
            .then(response => {
                updateCartView(response.data);
                window.location.reload();
            })
            .catch(error => console.error(error));
    }

    async function loadCart() {
        axios.post('/api/cart', {
                action: 'list'
            })
            .then(response => {
                updateCartView(response.data);
            })
            .catch(error => console.error(error));
    }

    async function addToCart(productId) {
        axios.post('/api/cart', {
                productId,
                action: 'add'
            })
            .then(response => {
                updateCartView(response.data);
            })
            .catch(error => console.error(error));
    }

    function updateCartView(cart) {
        const cartTotal = document.getElementById('cart-total');
        const numberItems = document.getElementById('cart-number-items');
        const totalItems = cart.items?.reduce((sum, item) => sum + item.quantity, 0) ?? 0;
        cartTotal.textContent = `S/ ${cart.total.toFixed(2)}`;
        numberItems.textContent = totalItems;
    }
    window.onload = loadCart;
</script>