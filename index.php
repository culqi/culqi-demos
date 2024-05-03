<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>CULQI DEMO CHECKOUT TARJETAS 3DS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      href="https://culqi.com/assets/images/brand/brand.svg"
      type="image/x-icon"
    />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <div class="w-full m-auto">
      <div
        class="max-w-7xl mt-10 mx-auto w-full flex flex-col sm:flex-row flex-grow overflow-hidden"
      >
        <?php include "components/sidebar.php" ?>
        <div
          class="w-full p-6 px-6 grid grid-cols-1 gap-4 place-content-center place-items-center"
        >
          <h1 class="my-6 text-xl font-bold text-center">PYTHON DEMO</h1>
          <h2 class="text-xl font-bold text-purple-800">
            CULQI - CUSTOM CHECKOUT
          </h2>
          <?php include "components/mode/with-create-card.html" ?>
          <?php include "components/mode/only-card.html" ?>
          <div class="mt-20">
            <button
              class="bg-blue-500 hover:bg-blue-700 px-5 py-4 leading-5 rounded-full font-semibold text-white text-2xl"
              id="reset"
            >
              Reiniciar
            </button>
          </div>
        </div>
      </div>
    </div>
    <script src="https://3ds.culqi.com" defer></script>
    <script src="https://js.culqi.com/checkout-js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"
      integrity="sha256-KdYARiowaU79FbmEi0ykLReM0GcAknXDWjBYASERQwQ="
      crossorigin="anonymous"
    ></script>

    <script type="module" src="./js/main.js" defer></script>
  </body>
</html>
