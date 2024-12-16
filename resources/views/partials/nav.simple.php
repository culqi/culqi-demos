<nav class="bg-gray-800 sticky">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex justify-between w-full md:block">
    <div class="flex h-16 items-center justify-between">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <img class="h-8 w-40" src="https://culqi.com/assets/images/brand/brandCulqi-white.svg" alt="Culqi">
        </div>
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">

            <a href="/" class="<?= urlIs('/') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>

            <?php if ($_SESSION['user'] ?? false): ?>
              <a href="/store" class="<?= urlIs('/store') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Tienda</a>
            <?php endif ?>

          </div>
        </div>
      </div>
      <div class="hidden md:block">
        <div class="ml-4 flex items-center md:ml-6">
          <?php if ($_SESSION['user'] ?? false): ?>
            <div class="ml-3">
              <button id="btnLogout" class="text-white">Log Out</button>
            </div>
          <?php else: ?>
            <div class="ml-3">
              <a href="/register" class="<?= urlIs('/register') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
              <a href="/login" class="<?= urlIs('/login') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Log
                In</a>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
    <div class="-mr-2 flex md:hidden">
      <button type="button"
        class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
        aria-controls="mobile-menu" aria-expanded="false">
        <span class="sr-only">Open main menu</span>

        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>

        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </div>

  <div class="md:hidden" id="mobile-menu">
    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
      <a href="/" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Inicio</a>

      <a href="/cart" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Carrito</a>

      <a href="/store" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Tienda</a>
    </div>
    <div class="border-t border-gray-700 pt-4 pb-3">
      <div class="flex items-center px-5">
        <div class="flex-shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 rounded-full text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 14c3.866 0 7-3.134 7-7S15.866 0 12 0 5 3.134 5 7s3.134 7 7 7zm0 2c-4.418 0-8 3.582-8 8h16c0-4.418-3.582-8-8-8z" />
          </svg>
        </div>
        <div class="ml-3">
          <div class="text-base font-medium leading-none text-white">Tom Cook</div>
          <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
        </div>
      </div>
      <div class="mt-3 space-y-1 px-2">
        <a href="/register" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Register</a>

        <a href="/login" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">login</a>

        <a href="/logout" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign out</a>
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnLogout = document.getElementById('btnLogout');
    if (btnLogout) {
      btnLogout.addEventListener('click', function () {
        axios.post('/auth/logout')
          .then(response => window.location.reload())
          .catch(error => console.error(error));
      });
    }
  });
</script>