<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $title ?? 'Demo Culqi'; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="shortcut icon" href="https://culqi.com/assets/images/brand/brand.svg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="./theme/assets/vendor/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="./theme/assets/css/font-electro.css">

    <link rel="stylesheet" href="./theme/assets/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="./theme/assets/vendor/hs-megamenu/src/hs.megamenu.css">
    <link rel="stylesheet" href="./theme/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="./theme/assets/vendor/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="./theme/assets/vendor/slick-carousel/slick/slick.css">
    <link rel="stylesheet" href="./theme/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css">

    <!-- CSS Electro Template -->
    <link rel="stylesheet" href="./theme/assets/css/theme.css">
    <link rel="stylesheet" href="./theme/assets/css/custom.css">
</head>

<body>
    <?php require base_path('resources/views/partials/header.php') ?>

    <main id="content" role="main">
        <?php echo $content; ?>
    </main>

    <?php require base_path('resources/views/partials/user-aside.php') ?>

    <!-- JS Global Compulsory -->
    <script src="./theme/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="./theme/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="./theme/assets/vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="./theme/assets/vendor/bootstrap/bootstrap.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="./theme/assets/vendor/appear.js"></script>
    <script src="./theme/assets/vendor/jquery.countdown.min.js"></script>
    <script src="./theme/assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>
    <script src="./theme/assets/vendor/svg-injector/dist/svg-injector.min.js"></script>
    <script src="./theme/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="./theme/assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="./theme/assets/vendor/fancybox/jquery.fancybox.min.js"></script>
    <script src="./theme/assets/vendor/typed.js/lib/typed.min.js"></script>
    <script src="./theme/assets/vendor/slick-carousel/slick/slick.js"></script>
    <script src="./theme/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

    <!-- JS Electro -->
    <script src="./theme/assets/js/hs.core.js"></script>
    <script src="./theme/assets/js/components/hs.countdown.js"></script>
    <script src="./theme/assets/js/components/hs.header.js"></script>
    <script src="./theme/assets/js/components/hs.hamburgers.js"></script>
    <script src="./theme/assets/js/components/hs.unfold.js"></script>
    <script src="./theme/assets/js/components/hs.focus-state.js"></script>
    <script src="./theme/assets/js/components/hs.malihu-scrollbar.js"></script>
    <script src="./theme/assets/js/components/hs.validation.js"></script>
    <script src="./theme/assets/js/components/hs.fancybox.js"></script>
    <script src="./theme/assets/js/components/hs.onscroll-animation.js"></script>
    <script src="./theme/assets/js/components/hs.slick-carousel.js"></script>
    <script src="./theme/assets/js/components/hs.show-animation.js"></script>
    <script src="./theme/assets/js/components/hs.svg-injector.js"></script>
    <script src="./theme/assets/js/components/hs.go-to.js"></script>
    <script src="./theme/assets/js/components/hs.selectpicker.js"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(window).on('load', function() {
            // initialization of HSMegaMenu component
            $('.js-mega-menu').HSMegaMenu({
                event: 'hover',
                direction: 'horizontal',
                pageContainer: $('.container'),
                breakpoint: 1199.98,
                hideTimeOut: 0
            });

            // initialization of svg injector module
            $.HSCore.components.HSSVGIngector.init('.js-svg-injector');
        });

        $(document).on('ready', function() {
            // initialization of header
            $.HSCore.components.HSHeader.init($('#header'));

            // initialization of animation
            $.HSCore.components.HSOnScrollAnimation.init('[data-animation]');

            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                afterOpen: function() {
                    $(this).find('input[type="search"]').focus();
                }
            });

            // initialization of popups
            $.HSCore.components.HSFancyBox.init('.js-fancybox');

            // initialization of countdowns
            var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
                yearsElSelector: '.js-cd-years',
                monthsElSelector: '.js-cd-months',
                daysElSelector: '.js-cd-days',
                hoursElSelector: '.js-cd-hours',
                minutesElSelector: '.js-cd-minutes',
                secondsElSelector: '.js-cd-seconds'
            });

            // initialization of malihu scrollbar
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

            // initialization of forms
            $.HSCore.components.HSFocusState.init();

            // initialization of form validation
            $.HSCore.components.HSValidation.init('.js-validate', {
                rules: {
                    confirmPassword: {
                        equalTo: '#signupPassword'
                    }
                }
            });

            // initialization of show animations
            $.HSCore.components.HSShowAnimation.init('.js-animation-link');

            // initialization of fancybox
            $.HSCore.components.HSFancyBox.init('.js-fancybox');

            // initialization of slick carousel
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

            // initialization of go to
            $.HSCore.components.HSGoTo.init('.js-go-to');

            // initialization of hamburgers
            $.HSCore.components.HSHamburgers.init('#hamburgerTrigger');

            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                beforeClose: function() {
                    $('#hamburgerTrigger').removeClass('is-active');
                },
                afterClose: function() {
                    $('#headerSidebarList .collapse.show').collapse('hide');
                }
            });

            $('#headerSidebarList [data-toggle="collapse"]').on('click', function(e) {
                e.preventDefault();

                var target = $(this).data('target');

                if ($(this).attr('aria-expanded') === "true") {
                    $(target).collapse('hide');
                } else {
                    $(target).collapse('show');
                }
            });

            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));

            // initialization of select picker
            $.HSCore.components.HSSelectPicker.init('.js-select');
        });
    </script>
</body>

</html>