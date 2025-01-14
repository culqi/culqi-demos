<div id="profile" style="display: none; opacity: 0;" data-target-group="idForm">
    <!-- Title -->
    <header class="text-center mb-7">
        <h2 class="h4 mb-0">Perfil</h2>
    </header>

    <h3 class="mb-0 pb-2 font-size-18"><strong>Nombre</strong> <br> <?= $_SESSION['user']['first_name'] ?></h4>
    <h3 class="mb-0 pb-2 font-size-18"><strong>Customer ID</strong> <?= $_SESSION['user']['customer_code'] ?></h2>
    <h3 class="mb-0 pb-2 font-size-18"><strong>Customer Email</strong> <?= $_SESSION['user']['customer_email'] ?></h2>
</div>