<aside id="sidebarContent" class="u-sidebar" aria-labelledby="sidebarNavToggler">
    <div class="u-sidebar__scroller">
        <div class="u-sidebar__container">
            <div class="js-scrollbar u-header-sidebar__footer-offset pb-3">
                <!-- Toggle Button -->
                <div class="d-flex align-items-center pt-4 px-7">
                    <button type="button" class="close ml-auto" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false"
                        data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent"
                        data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                        data-unfold-duration="500">
                        <i class="ec ec-close-remove"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->

                <!-- Content -->
                <div class="js-scrollbar u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">
                        <div>
                            <!-- Login -->
                            <?php require base_path('resources/views/auth/login.php') ?>
                            <!-- Signup -->
                            <?php require base_path('resources/views/auth/register.php') ?>
                            <!-- Profile -->
                            <?php require base_path('resources/views/auth/profile.php') ?>
                            <!-- Cards -->
                            <?php require base_path('resources/views/partials/cards.php') ?>
                        </div>
                    </div>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('[data-target]');
        const forms = document.querySelectorAll('[data-target-group="idForm"]');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');

                // Ocultar todos los formularios
                forms.forEach(form => {
                    form.style.display = 'none';
                    form.style.opacity = '0';
                });

                // Mostrar el formulario objetivo
                const targetForm = document.querySelector(targetId);
                if (targetForm) {
                    targetForm.style.display = 'block';
                    setTimeout(() => {
                        targetForm.style.opacity = '1';
                    }, 100); // Pequeña demora para la transición
                }
            });
        });
    });
</script>