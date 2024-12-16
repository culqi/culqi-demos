<?php require('components/components.php') ?>

<main>
  <section class="bg-white py-12">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold mb-4">Custom Checkout con 3DS</h2>
      <p class="text-gray-600 text-lg mb-6">Una solución perfecta para probar flujos de pago, checkout personalizado y seguridad avanzada con 3D Secure.</p>
    </div>
  </section>

  <section id="features" class="py-12 bg-gray-100">
    <div class="container mx-auto">
      <h3 class="text-3xl font-bold text-center mb-8">Características</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php

        echo renderCard('Custom Checkout', 'En esta demo se utiliza el checkout personalizado de Culqi para ofrecer una experiencia adaptada y segura al usuario.', 'https://docs.culqi.com/es/documentacion/checkout/v4/culqi-checkout-custom/');
        echo renderCard('3DS', 'Integramos la funcionalidad 3D Secure de Culqi en esta demo para garantizar una capa adicional de seguridad en las transacciones.', 'https://docs.culqi.com/es/documentacion/culqi-3ds/');
        echo renderCard('SDK Culqi PHP', 'En esta demo hacemos uso del SDK Culqi para PHP, facilitando la conexión con la API de Culqi y simplificando las integraciones.', 'https://github.com/culqi/culqi-php');
        echo renderCard('Proceso de Pago con Carrito', 'Experimenta en esta demo cómo agregar productos al carrito, revisar el pedido y completar el pago de manera sencilla.');
        echo renderCard('Cargo Único', 'En esta demo se realiza un cargo único a través del checkout personalizado para pagos directos.', 'https://docs.culqi.com/es/documentacion/pagos-online/cargo-unico/resumen/');
        echo renderCard('Subscripciones y/o Cargos Recurrentes', 'Implementamos pagos recurrentes en esta demo, utilizando tarjetas previamente guardadas para optimizar las suscripciones.', 'https://docs.culqi.com/es/documentacion/pagos-online/recurrencia/suscripciones/resumen/');
        ?>
      </div>
    </div>
  </section>

  <section id="authentication" class="py-12 bg-white">
    <div class="container mx-auto text-center">
      <h3 class="text-3xl font-bold mb-6">Comienza Ahora</h3>
      <p class="text-gray-600 text-lg mb-6">Para acceder a la demo, por favor regístrate o inicia sesión en tu cuenta.</p>
      <a href="/register" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 mr-4">Regístrate</a>
      <a href="/login" class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow-lg hover:bg-gray-700">Inicia Sesión</a>
    </div>
  </section>
</main>