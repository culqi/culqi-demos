<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>CULQI DEMO CHECKOUT TARJETAS 3DS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="shortcut icon" href="https://culqi.com/assets/images/brand/brand.svg" type="image/x-icon">
</head>
<body>
  <div class="container">
    <h2>CHECKOUT V4<br />(Órdenes y Cargos + 3DS)</h2>
    <div class="card-body">
        <div class="col-md-6">
          <a id="crearCharge" class="btn btn-primary btn-lg" href="#">Realizar Pago</a><br /><br />
          <div class="panel panel-default" id="response-panel">
          <div class="panel-heading">Respuesta</div>
          <div class="panel-body" id="response_card"></div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://3ds.culqi.com" defer></script>
  <script src="https://js.culqi.com/checkout-js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
      const paymenType = "cargo";
  </script>
  <script type="module" src="./js/main.js" defer></script>

  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      function resultdiv(message) {
        $('#response').html(message);
      }

      function resultpe(message) {
        $('#response').html(message);
      }
    });
  </script>

</body>

</html>
