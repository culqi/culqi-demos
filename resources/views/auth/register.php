<?php

use App\Config\Config;

$title = 'Register';

$constants = [
    'baseURL' =>   Config::API_BASE_URL,
    'secret_key' => Config::SECRET_KEY ?? 'empty',
    'public_key' => Config::PUBLIC_KEY ?? 'empty',
];
?>

<div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">
    <!-- Title -->
    <header class="text-center mb-7">
        <h2 class="h4 mb-0">Regístrate con nosotros</h2>
        <p>Completa el formulario de registro.</p>
    </header>
    <!-- End Title -->

    <form id="registerForm">
        <!-- First Name -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="firstName">Nombre</label>
                <input type="text" class="form-control" name="first_name" id="firstName" placeholder="Nombre" required maxlength="50"
                    pattern="^[a-zA-Z ]+$">
                <p class="text-red d-none" id="firstNameError">El nombre debe contener entre 2 y 50 caracteres alfabéticos.</p>
            </div>
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="lastName">Apellido</label>
                <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Apellido" required maxlength="50"
                    pattern="^[a-zA-Z ]+$">
                <p class="text-red d-none" id="lastNameError">El apellido debe contener entre 2 y 50 caracteres alfabéticos.</p>
            </div>
        </div>

        <!-- Email -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="emailRegister">Email</label>
                <input type="email" class="form-control" name="emailRegister" id="emailRegister" placeholder="Correo electrónico" required
                    maxlength="50" autocomplete="off">
                <p class="text-red d-none" id="emailRegisterError">Ingresa un correo electrónico válido.</p>
            </div>
        </div>

        <!-- Password -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="password">Contraseña</label>
                <input type="password" class="form-control" name="passwordRegister" id="passwordRegister" placeholder="Contraseña" required
                    minlength="8" maxlength="50" autocomplete="off">
                <p class="text-red d-none" id="passwordRegisterError">La contraseña debe tener al menos 8 caracteres.</p>
            </div>
        </div>

        <!-- Address -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="address">Dirección</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Dirección" required minlength="5" maxlength="100">
                <p class="text-red d-none" id="addressError">La dirección debe contener entre 5 y 100 caracteres.</p>
            </div>
        </div>

        <!-- City -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="address_city">Ciudad</label>
                <input type="text" class="form-control" name="address_city" id="address_city" placeholder="Ciudad" required minlength="2"
                    maxlength="30">
                <p class="text-red d-none" id="addressCityError">La ciudad debe contener entre 2 y 30 caracteres.</p>
            </div>
        </div>

        <!-- Country Code -->
        <div class="form-group">
            <label for="countryCode">Selecciona el país</label>
            <select class="form-control" name="country_code" id="countryCode" required>
                <option value="PE" selected>Perú</option>
                <option value="US">Estados Unidos</option>
            </select>
        </div>

        <!-- Phone Number -->
        <div class="form-group">
            <div class="js-form-message js-focus-state">
                <label class="sr-only" for="phoneNumber">Teléfono</label>
                <input type="text" class="form-control" name="phone_number" id="phoneNumber" placeholder="Teléfono" required minlength="5"
                    maxlength="15">
                <p class="text-red d-none" id="phoneNumberError">El teléfono debe contener entre 5 y 15 caracteres.</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mb-2">
            <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover text-white" id="submitButton">Registrarse</button>
        </div>
    </form>
</div>

<script type="module">
    import {
        customer
    } from "./assets/js/config/checkout.js";

    const nameInput = document.getElementById("firstName");
    const emailInput = document.getElementById("emailRegister");
    const passwordInput = document.getElementById("passwordRegister");
    const addressInput = document.getElementById("address");
    const addressCityInput = document.getElementById("address_city");
    const phoneInput = document.getElementById("phoneNumber");
    const submitButton = document.getElementById("submitButton");

    const emailError = document.getElementById("emailRegisterError");
    const passwordError = document.getElementById("passwordRegisterError");
    const addressError = document.getElementById("addressError");
    const addressCityError = document.getElementById("addressCityError");
    const phoneError = document.getElementById("phoneNumberError");

    let isEmailValid = false;
    let isPasswordValid = false;

    // Validaciones
    const validateEmail = (email) => {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    };

    const validatePassword = (password) => password.length >= 8;

    const validatePhone = (phone) => phone.length >= 5 && phone.length <= 15;
    const validateAddress = (address) => address.length >= 5 && address.length <= 100;
    const validateCity = (city) => city.length >= 2 && city.length <= 30;

    const checkFormValidity = () => {
        submitButton.disabled = !(isEmailValid && isPasswordValid && validatePhone(phoneInput.value) && validateAddress(addressInput.value) &&
            validateCity(addressCityInput.value));
    };

    emailInput.addEventListener("input", () => {
        isEmailValid = validateEmail(emailInput.value);
        emailError.classList.toggle("d-none", isEmailValid);
        checkFormValidity();
    });

    passwordInput.addEventListener("input", () => {
        isPasswordValid = validatePassword(passwordInput.value);
        passwordError.classList.toggle("d-none", isPasswordValid);
        checkFormValidity();
    });

    phoneInput.addEventListener("input", () => {
        phoneError.classList.toggle("d-none", validatePhone(phoneInput.value));
        checkFormValidity();
    });

    addressInput.addEventListener("input", () => {
        addressError.classList.toggle("d-none", validateAddress(addressInput.value));
        checkFormValidity();
    });

    addressCityInput.addEventListener("input", () => {
        addressCityError.classList.toggle("d-none", validateCity(addressCityInput.value));
        checkFormValidity();
    });


    const form = document.getElementById('registerForm');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        if (!isEmailValid || !isPasswordValid || !validatePhone(phoneInput.value) || !validateAddress(addressInput.value) || !validateCity(
                addressCityInput.value)) {
            alert('Por favor, complete correctamente el formulario');
            return;
        }
        const formData = new FormData(form);
        const jsonData = Object.fromEntries(formData);

        const CONSTANTS = <?= json_encode($constants) ?>;
        const configParams = {
            secretKey: CONSTANTS.secret_key,
            baseURL: CONSTANTS.baseURL,
        };

        const customerData = {
            first_name: jsonData.first_name,
            last_name: jsonData.last_name,
            email: jsonData.emailRegister,
            password: jsonData.passwordRegister,
            address: jsonData.address,
            address_city: jsonData.address_city,
            country_code: jsonData.country_code,
            phone_number: jsonData.phone_number,
        };

        customer.createCustomer(customerData, configParams)
            .then(response => {
                console.log(response);
                if (response.statusCode === 201) {
                    window.location.href = '/store';
                } else {
                    alert(response.data.merchant_message);
                }
            })
            .catch(error => {
                console.error('Error al registrar el usuario:', error);
                alert('Hubo un error al procesar tu registro. Por favor, intenta más tarde.', error.merchant_message);
            });
    });
</script>