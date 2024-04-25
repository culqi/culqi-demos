<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="https://culqi.com/assets/images/brand/brand.svg" type="image/x-icon">
  <title>CULQI JS V4 - DEMO</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.2/dist/flowbite.min.css" />
  <link rel="stylesheet" href="waitMe.min.css" />
  <link href='https://css.gg/css' rel='stylesheet'>
</head>

<body>
  <div class=" w-full m-auto">
    <h1 class="my-6 text-xl font-bold text-center">Culqi-JS v4 Personalizado</h1>
    <div class="max-w-7xl mt-10 mx-auto w-full flex flex-col sm:flex-row flex-grow overflow-hidden">
      <?php include "components/sidebar.html" ?>

      <div class="w-full p-6 px-6 grid grid-cols-1 gap-4 place-content-center place-items-center" id="content-culqijs">
        <div id="amount" style="width: 800px; float: right; text-align: right; font-weight: 500;"></div>
        </br>
        <?php include "components/payments-methods/token.html" ?>
        <?php include "components/payments-methods/cip.html" ?>
        <?php include "components/payments-methods/cuotealo.html" ?>
        <?php include "components/payments-methods/yape.html" ?>
        <div>

          <div class="panel panel-default" id="response-panel">
            <div class="panel-heading">Response</div>
            <div class="panel-body" id="response">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/flowbite@1.5.2/dist/flowbite.js"></script>
  <script src="https://3ds.culqi.com" defer></script>
  <script src="https://checkout.culqi.com/js/v4"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script type="module" src="js/main.js" defer></script>

  <script>
    function desactivaBoton(element) {
      element.disabled = true;
    }
    const openCheckout = document.querySelector('#open-checout');
    openCheckout.addEventListener('click', event => {
      console.log("Dentro a openCheckout");
      Culqi.open();
    })
  </script>
  <script src="waitMe.min.js"></script>
</body>

</html>
