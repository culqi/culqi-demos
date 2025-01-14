<header id="header" class="u-header u-header-left-aligned-nav mb-4">
    <div class="u-header__section">
        <!-- Logo-Search-header-icons -->
        <div class="bg-primary">
            <div class="container">
                <div class="row min-height-64 align-items-center position-relative">
                    <!-- Logo-offcanvas-menu -->
                    <div class="col-auto">
                        <!-- Nav -->
                        <nav class="navbar navbar-expand u-header__navbar py-0 max-width-200 min-width-200">
                            <!-- Logo -->
                            <a class="order-1 order-xl-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-center" href="/"
                                aria-label="Culqi">
                                <img src="https://culqi.com/assets/images/brand/brandCulqi-white.svg" alt="Logo">
                            </a>
                            <!-- End Logo -->
                        </nav>
                        <!-- End Nav -->
                    </div>
                    <!-- End Logo-offcanvas-menu -->
                    <!-- Search Bar -->
                    <div class="col d-none d-xl-block">
                        <form class="js-focus-state">
                            <label class="sr-only" for="searchproduct">Search</label>
                            <div class="input-group">
                                <input type="email"
                                    class="form-control py-2 pl-5 font-size-15 border-right-0 height-42 border-width-0 rounded-left-pill border-primary"
                                    name="email" id="searchproduct-item" placeholder="Busqueda de productos" aria-label="Search for Products"
                                    aria-describedby="searchProduct1" required>
                                <div class="input-group-append">
                                    <button class="btn btn-dark height-42 py-2 px-3 rounded-right-pill" type="button" id="searchProduct1">
                                        <span class="ec ec-search font-size-20"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End Search Bar -->
                    <!-- Header Icons -->
                    <div class="col col-xl-auto text-right text-xl-left pl-0 pl-xl-3 position-static">
                        <div class="d-inline-flex">
                            <ul class="d-flex list-unstyled mb-0 align-items-center">
                                <!-- Search -->
                                <li class="col d-xl-none px-2 px-sm-3 position-static">
                                    <a id="searchClassicInvoker" class="font-size-22 text-gray-90 text-lh-1 btn-text-secondary" href="javascript:;"
                                        role="button" data-toggle="tooltip" data-placement="top" title="Search" aria-controls="searchClassic"
                                        aria-haspopup="true" aria-expanded="false" data-unfold-target="#searchClassic"
                                        data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300"
                                        data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                        <span class="ec ec-search"></span>
                                    </a>

                                    <!-- Input -->
                                    <div id="searchClassic" class="dropdown-menu dropdown-unfold dropdown-menu-right left-0 mx-2"
                                        aria-labelledby="searchClassicInvoker">
                                        <form class="js-focus-state input-group px-3">
                                            <input class="form-control" type="search" placeholder="Search Product">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary px-3" type="button"><i class="font-size-18 ec ec-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End Input -->
                                </li>
                                <!-- End Search -->
                                <?php if ($_SESSION['user'] ?? false): ?>
                                    <li class="col d-none d-xl-block">
                                        <a href="/store" role="button" class="text-white d-flex align-items-center">

                                            <i class="font-size-18 fas fa-home me-2" style="margin-top: 6px;"></i>
                                            <span style="margin-top: 4px; margin-left: 13px;">Tienda</span>
                                        </a>
                                    </li>

                                    <li class="col d-none d-xl-block">
                                        <a href="javascript:;" role="button" id="sidebarNavTogglerLogin" class="text-white d-flex align-items-center"
                                            data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent"
                                            data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight"
                                            data-unfold-animation-out="fadeOutRight" data-unfold-duration="500" data-target="#profile"
                                            data-link-group="idForm" data-animation-in="slideInUp">
                                            <i class="font-size-22 fas fa-user-circle me-2" style="margin-top: 6px;"></i>
                                            <span style="margin-top: 4px; margin-left: 13px;">Perfil</span>
                                        </a>
                                    </li>

                                    <li class="col d-none d-xl-block" style="flex: auto;">
                                        <a href="javascript:;" role="button" id="sidebarNavTogglerLogin" class="text-white d-flex align-items-center"
                                            data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent"
                                            data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight"
                                            data-unfold-animation-out="fadeOutRight" data-unfold-duration="500" data-target="#misTarjetas"
                                            data-link-group="idForm" data-animation-in="slideInUp">
                                            <i class="font-size-22 fas fa-credit-card me-2" style="margin-top: 6px;"></i>
                                            <span style="margin-top: 4px; margin-left: 13px; margin-right: -26px;">Mis Tarjetas</span>
                                        </a>
                                    </li>

                                    <li class="col pr-xl-0 px-2 px-sm-3" style="margin-left: 23px;">
                                        <a href="javascript:;" id="btnLogout" role="button" class="text-white d-flex align-items-center">

                                            <i class="font-size-18 fas fa-user-lock me-2" style="margin-top: 6px;"></i>
                                            <span style="margin-top: 4px; margin-left: 13px;">LogOut</span>
                                        </a>
                                    </li>

                                    <li class="col pr-xl-0 px-2 px-sm-3">
                                        <a href="/cart" class="text-white position-relative d-flex ">
                                            <i class="font-size-22 ec ec-shopping-bag"></i>
                                            <span
                                                class="width-22 height-22 bg-culqi position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white"
                                                id="cart-number-items">0</span>
                                        </a>
                                    </li>
                                    <li class="pr-xl-0 px-2 px-sm-3 mt-2" style="flex: none;">
                                        <span class="d-none d-xl-block font-weight-bold font-size-16 text-white ml-3" id="cart-total">
                                            S/ 0.00
                                        </span>
                                    </li>
                                <?php else: ?>
                                    <li class="col d-none d-xl-block">
                                        <a href="javascript:;" role="button" id="sidebarNavToggler" class="text-white d-flex align-items-center"
                                            data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent"
                                            data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight"
                                            data-unfold-animation-out="fadeOutRight" data-unfold-duration="500" data-target="#signup"
                                            data-link-group="idForm" data-animation-in="slideInUp">
                                            <i class="font-size-22 ec ec-gamepad me-2"></i>
                                            <span style="margin-top: 6px; margin-left: 13px;">Registro</span>
                                        </a>
                                    </li>
                                    <li class="col d-none d-xl-block">
                                        <a href="javascript:;" role="button" id="sidebarNavTogglerLogin" class="text-white d-flex align-items-center"
                                            data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent"
                                            data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight"
                                            data-unfold-animation-out="fadeOutRight" data-unfold-duration="500" data-target="#login"
                                            data-link-group="idForm" data-animation-in="slideInUp">
                                            <i class="font-size-22 ec ec-user me-2" style="margin-top: 6px;"></i>
                                            <span style="margin-top: 4px; margin-left: 13px;">Login</span>
                                        </a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                    <!-- End Header Icons -->
                </div>
            </div>
        </div>
        <!-- End Logo-Search-header-icons -->
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejo del logout
        const btnLogout = document.getElementById('btnLogout');
        if (btnLogout) {
            btnLogout.addEventListener('click', function() {
                axios.post('/auth/logout')
                    .then(response => window.location.reload())
                    .catch(error => console.error(error));
            });
        }
    });
</script>


<script>
    async function clearCart() {
        axios.post('/api/cart/clear', {
                action: 'clear'
            })
            .then(response => {
                updateCartView(response.data);
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