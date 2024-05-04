<?php
$ruta_relativa = htmlspecialchars($_SERVER['PHP_SELF']);
?>
<aside class="w-64" aria-label="Sidebar">
  <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800 h-full pt-20">
    <a
      href="https://docs.culqi.com/es/documentacion/"
      class="flex items-center pl-2.5 mb-5"
    >
      <img
        src="https://culqi.com/assets/images/brand/brandCulqi-white.svg"
        class="mr-3 h-6 sm:h-7"
        alt="Culqi Logo"
      />
    </a>
    <ul class="space-y-2">
      <li>
        <div
          class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white w-full justify-between"
        >
          <span class="ml-3 text-left whitespace-nowrap">Cargos</span>
          <svg
            class="w-6 h-6"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </div>
        <div>
          <ul class="py-2 pl-8 space-y-2">
            <li>
              <a
                href="<?php echo $ruta_relativa; ?>?mode=only-charge"
                data-mode-menu="only-charge"
                class="flex items-start p-2 w-full text-base font-normal text-left text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
              >
                Solo Cargo
              </a>
            </li>
            <li>
              <a
                href="<?php echo $ruta_relativa; ?>?mode=with-card"
                data-mode-menu="with-card"
                class="flex items-start p-2 w-full text-base font-normal text-left text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
              >
                Con creación tarjeta
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</aside>
<script type="text/javascript">
  let paymentType;
  document.addEventListener("DOMContentLoaded", () => {
    const modesMenus = document.querySelectorAll("[data-mode-menu]");

    const activeMenu = () => {
      const urlParams = new URLSearchParams(window.location.search);
      const mode = urlParams.get("mode") || "only-charge";

      const menu = document.querySelector(`[data-mode-menu="${mode}"]`);
      menu.classList.add("border-l-2", "border-white", "dark:bg-gray-700");
      paymentType = mode;
      const content = document.querySelector(`[data-mode-content="${mode}"]`);

      if (content) {
        content.classList.remove("hidden");
      }
    };
    activeMenu();
    const getPaymentMethods = (target, selector) => {
      let obj = {
        methods: []
      };
      modesMenus.forEach((el) => {
        const data = el.getAttribute(selector);
        if (data !== target) {
          obj.methods = [...obj.methods, document.getElementById(data)];
        } else {
          obj.current = document.getElementById(data);
        }
      });
      return obj;
    };

    modesMenus.forEach((method) => {
      method.addEventListener("click", async (el) => {
        const target = method.getAttribute("data-mode-menu");
        const targetElement = document.getElementById(target);

        const obj = getPaymentMethods(target, "data-mode-menu");

        if (!obj.current) {
          window.location.href = window.location.pathname + "?mode=" + target;
        }
        activeMenu();
        await window.handledContentLoad();
      });
    });
  });
</script>
