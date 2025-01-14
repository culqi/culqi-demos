<?php
$title = 'Login';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $emailIsValid = filter_var($email, FILTER_VALIDATE_EMAIL);
    $passwordIsValid = strlen($password) >= 8;

    if ($emailIsValid && $passwordIsValid) {
        echo "Login successful!";
    } else {
        echo "Invalid input.";
    }
}
?>

<div id="login" data-target-group="idForm">
    <!-- Title -->
    <header class="text-center mb-7">
        <h2 class="h4 mb-0">Bienvenido!</h2>
        <p>Ingresa tus credenciales.</p>
    </header>
    <!-- End Title -->
    <form id="loginForm" method="POST">
        <!-- Form Group -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="email">Email</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="signinEmailLabel">
                            <span class="fas fa-user"></span>
                        </span>
                    </div>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" aria-label="Email"
                        aria-describedby="signinEmailLabel" autocomplete="off" required>
                </div>
                <p class="text-red d-none" id="emailError">Email invalido</p>
            </div>
        </div>
        <!-- End Form Group -->

        <!-- Form Group -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="password">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="signinPasswordLabel">
                            <span class="fas fa-lock"></span>
                        </span>
                    </div>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" aria-label="Password"
                        aria-describedby="signinPasswordLabel" autocomplete="off" required>

                </div>
                <p class="text-red d-none" id="passwordError">La contraseña debe tener al menos 8 caracteres</p>
            </div>
        </div>
        <!-- End Form Group -->

        <div class="mb-2">
            <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover text-white" id="loginButton">Login</button>
        </div>
    </form>
    <div class="text-center mb-4">
        <span class="">No tienes una cuenta?</span>
        <a class="js-animation-link " href="javascript:;" data-target="#signup" data-link-group="idForm" data-animation-in="slideInUp">Registrate
        </a>
    </div>

    <div class="text-center">
        <span class="u-divider u-divider--xs u-divider--text mb-4">O</span>
    </div>

    <!-- Login Buttons -->
    <div class="d-flex">
        <a class="btn btn-block btn-sm btn-soft-facebook transition-3d-hover mr-1" href="#">
            <span class="fab fa-facebook-square mr-1"></span>
            Facebook
        </a>
        <a class="btn btn-block btn-sm btn-soft-google transition-3d-hover ml-1 mt-0" href="#">
            <span class="fab fa-google mr-1"></span>
            Google
        </a>
    </div>
    <!-- End Login Buttons -->
</div>

<script>
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const loginButton = document.getElementById('loginButton');

    emailInput.addEventListener('input', () => {
        if (!emailInput.checkValidity()) {
            emailError.classList.remove('hidden');
        } else {
            emailError.classList.add('hidden');
        }

    });

    passwordInput.addEventListener('input', () => {
        if (passwordInput.value.length < 8) {
            passwordError.classList.remove('hidden');
        } else {
            passwordError.classList.add('hidden');
        }

    });

    const form = document.getElementById('loginForm');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = Object.fromEntries(new FormData(form));

        axios.post('/auth/login', formData)
            .then(({
                data
            }) => {
                const formatJson = JSON.parse(data);
                if (formatJson.isLogin) {
                    window.location.href = '/store';
                } else {
                    alert('Error');
                }
            })
            .catch(error => {
                console.log('Error');
            });
    });
</script>