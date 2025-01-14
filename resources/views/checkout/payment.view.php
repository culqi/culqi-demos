<?php
// payment.view.php
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
        <?php
        $paymentStatus = $_GET['paymentStatus'] ?? 'failed';
        $paymentCode = $_GET['paymentCode'] ?? '';
        ?>

        <div class="text-center">
            <?php if ($paymentStatus === 'success' && $paymentCode !== "undefined"): ?>
                <svg style="width: 100px; color: green;" xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-500 mx-auto" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <h2 class="text-2xl font-semibold text-green-600 mt-4">¡Pago Exitoso!
                    <br>
                    <strong>Codigo: <?= $paymentCode ?></strong>
                </h2>
                <p class="text-gray-600 mt-2">Tu pago se ha procesado con éxito. ¡Gracias por tu compra!</p>
            <?php else: ?>
                <svg style="width: 100px; color: red;" xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-red-500 mx-auto" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <h2 class="text-2xl font-semibold text-red-600 mt-4">¡Error en el Pago!</h2>
                <p class="text-gray-600 mt-2">Hubo un problema al procesar tu pago. Por favor, intenta nuevamente.</p>
            <?php endif; ?>

            <div class="mt-6">
                <a href="/store" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200">Volver
                    al checkout</a>
            </div>
        </div>
    </div>
</div>