<?php

use App\Config\Config;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cart = $_SESSION['cart'];

$total = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

$constants = [
    'baseURL' =>   Config::API_BASE_URL,
    'customer_code' => $_SESSION['user']['customer_code'] ?? 'cus_empty',
    'secret_key' => Config::SECRET_KEY ?? 'empty',
    'public_key' => Config::PUBLIC_KEY ?? 'empty',
    'amount' => $total * 100,
    'currency' => 'PEN',
];

$checkoutURL = Config::CHECKOUT_URL;
?>


<div class="container">
    <div class="mb-5">
        <h1 class="text-center">Checkout</h1>
    </div>
    <div class="row">
        <div class="col-lg-8 order-lg-2 mb-7 mb-lg-0 mx-auto">
            <div class="pl-lg-3 ">
                <div class="bg-gray-1 rounded-lg">
                    <!-- Order Summary -->
                    <div class="p-4 mb-4 checkout-table">
                        <!-- Title -->
                        <div class="border-bottom border-color-1 mb-5">
                            <h3 class="section-title mb-0 pb-2 font-size-25">Tu orden</h3>
                        </div>
                        <!-- End Title -->

                        <!-- Product Content -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-name">Productos</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <tr class="cart_item">
                                        <td><?= htmlspecialchars($item['name']) ?> <strong class="product-quantity">× <?= $item['quantity'] ?></strong>
                                        </td>
                                        <td>S/ <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <td><strong>S/ <?= number_format($total, 2) ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="border-top border-width-3 border-color-1 pt-3 mb-3">
                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                <div class="p-3">
                                    <div class="custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input" id="stylishRadio1">
                                        <label class="custom-control-label form-label" for="stylishRadio1" id="toggleTitle">
                                            Mis tarjetas registradas
                                        </label>
                                    </div>
                                </div>
                                <div id="content1" class="collapse border-top border-color-1 border-dotted-top ">
                                    <table class="table table-bordered table-striped w-full text-center border-collapse">
                                        <thead>
                                            <tr>
                                                <th class="border-b py-2">Codigo</th>
                                                <th class="border-b py-2">Email</th>
                                                <th class="border-b py-2">Tarjeta</th>
                                                <th class="border-b py-2">Creacion</th>
                                                <th class="border-b py-2 text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="card-list"></tbody>
                                    </table>
                                    <button type="button" id="tokenizedCard"
                                        class="btn btn-primary shadow-none text-white mx-auto w-25 btn-block btn-pill font-size-14 mb-3 py-3">Agregar
                                        nueva
                                        tarjeta</button>
                                </div>
                            </div>
                        </div>
                        <div id="content2" class="collapse show">
                            <div class="form-group d-flex align-items-center justify-content-between px-3 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck10" required
                                        data-msg="Please agree terms and conditions." data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    <label class="form-check-label form-label" for="defaultCheck10">
                                        Registrar tarjeta para futuras compras
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                            <button type="button" id="paymentBtn"
                                class="btn btn-primary shadow-none text-white  btn-block btn-pill font-size-18 mb-3 py-3">Pagar</button>
                        </div>
                    </div>
                    <!-- End Order Summary -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= $checkoutURL ?>"></script>
<script type="module">
    import {
        checkout
    } from "./assets/js/config/checkout.js";

    const btnTokenizedCard = document.getElementById('tokenizedCard');
    btnTokenizedCard.addEventListener('click', (e) => {
        e.preventDefault();
        TokenizedCard();
    })

    const btnPaymentBtn = document.getElementById('paymentBtn');
    btnPaymentBtn.addEventListener('click', (e) => {
        e.preventDefault();
        PaymentCheckout();
    })

    async function TokenizedCard() {
        const CONSTANTS = <?= json_encode($constants) ?>;

        const configParams = {
            orderId: "123456",
            amount: 0,
            buttonTex: "Agregar Tarjeta",
            title: "Agregar tarjeta",
            currency: "PEN",
            customer_code: CONSTANTS.customer_code,
            publicKey: CONSTANTS.public_key,
            secretKey: CONSTANTS.secret_key,
            baseURL: CONSTANTS.baseURL,
        };

        checkout.open(configParams);
    }

    function payCard(card) {
        const CONSTANTS = <?= json_encode($constants) ?>;

        const configParams = {
            sourceId: card.id,
            amount: CONSTANTS.amount,
            currency: CONSTANTS.currency,
            email: card.email,
            token_id: card.token_id,

            buttonTex: "Agregar Tarjeta",
            title: "Pagos con tarjeta",
            publicKey: CONSTANTS.public_key,
            secretKey: CONSTANTS.secret_key,
            baseURL: CONSTANTS.baseURL,
        };

        checkout.payCard(configParams);
    }

    function PaymentCheckout() {
        const CONSTANTS = <?= json_encode($constants) ?>;

        const configParams = {
            amount: CONSTANTS.amount,
            currency: CONSTANTS.currency,
            buttonTex: "Pagar con monto de",
            title: "Pagar",
            customer_code: CONSTANTS.customer_code,
            publicKey: CONSTANTS.public_key,
            secretKey: CONSTANTS.secret_key,
            baseURL: CONSTANTS.baseURL,
        };

        const defaultCheck10 = document.getElementById('defaultCheck10');

        checkout.payCheckout(configParams, defaultCheck10.checked);
    }

    function loadCards() {
        axios.post('/api/card/list')
            .then(response => {
                const tableBody = document.getElementById('card-list');
                tableBody.innerHTML = '';
                response.data.forEach(card => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td class="border-b py-2">${card.id}</td>
                    <td class="border-b py-2">${card.email}</td>
                    <td class="border-b py-2">${card.card_number}</td>
                    <td class="border-b py-2">${card.creation_date}</td>                
                    <td class="border-b py-2">
                    <div class="flex space-x-2 text-center">
                        <button class="bg-green border-0 text-white px-2 py-1 rounded-lg pay-card-btn" data-card='${JSON.stringify(card)}'>
                            Pagar
                        </button>
                        <button class="bg-danger border-0 text-white px-2 py-1 rounded-lg remove-card-btn" data-card-id="${card.id}">
                            Eliminar
                        </button>
                    </div>
                    </td>
                `;
                    tableBody.appendChild(row);
                });

                document.querySelectorAll('.pay-card-btn').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const card = JSON.parse(e.target.getAttribute('data-card'));
                        payCard(card);
                    });
                });

                document.querySelectorAll('.remove-card-btn').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const cardId = e.target.getAttribute('data-card-id');
                        removeCard(cardId);
                    });
                });
            })
            .catch(error => console.error(error));
    }

    function removeCard(cardId) {
        axios.delete(`/api/card/${cardId}`)
            .then(response => {
                alert('Tarjeta eliminada exitosamente');
                loadCards();
            })
            .catch(error => console.error(error));
    }

    loadCards();
</script>


<script>
    const radioInput = document.getElementById("stylishRadio1");
    const content1 = document.getElementById("content1");
    const content2 = document.getElementById("content2");

    radioInput.addEventListener("change", function() {
        if (radioInput.checked) {
            content1.classList.add("show");
            content1.classList.remove("collapse");
            content2.classList.remove("show");
            content2.classList.add("collapse");
        } else {
            content2.classList.add("show");
            content2.classList.remove("collapse");
            content1.classList.remove("show");
            content1.classList.add("collapse");
        }
    });
</script>