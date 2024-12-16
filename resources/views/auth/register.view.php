<?php
$title = 'Register';
$errors = [
  'email' => 'Email is required',
  'password' => 'Password is required',
  'confirm_password' => 'Confirm Password is required'
];
?>
<script type="module" src="<?php echo asset('js/validation.js'); ?>"></script>

<div class="flex items-center justify-center h-screen">
  <div class="w-full max-w-md">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="registerForm" method="POST">
      <h2 class="text-center text-2xl font-bold mb-6">Registrar</h2>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
          Nombre
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" placeholder="Nombre"
          required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
          Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email"
          placeholder="Email" onblur="validateInput(this, 'email')" onfocus="clearError(this)" required>
        <p class="text-red-500 text-xs italic hidden" id="email-error">
          El formato del email no es válido
        </p>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Contraseña
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password"
          placeholder="******************" onblur="validateInput(this)" onfocus="clearError(this)" required>
        <p class="text-red-500 text-xs italic hidden" id="password-error">
          La contraseña debe tener al menos 8 caracteres
        </p>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
          Confirmar Contraseña
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="confirm_password" name="confirm_password"
          type="password" placeholder="******************" onblur="validateInput(this)" onfocus="clearError(this)" required>
        <p class="text-red-500 text-xs italic hidden" id="confirm_password-error">
          Las contraseñas no coinciden
        </p>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" id="submitButton" disabled>
          Registrar
        </button>
        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="/login">
          ¿Ya tienes una cuenta?
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  const submitButton = document.getElementById("submitButton");
  const emailError = document.getElementById("email-error");
  const passwordError = document.getElementById("password-error");
  const confirmPassword = document.getElementById("confirm_password");
  const confirmPasswordError = document.getElementById(
    "confirm_password-error"
  );

  let isEmailValid = false;
  let isPasswordValid = false;

  const validateEmail = (email) => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  };

  const validatePassword = (password) => {
    return password.length >= 8;
  };

  const checkFormValidity = () => {
    submitButton.disabled = !(isEmailValid && isPasswordValid);
  };

  nameInput.addEventListener("input", () => {
    checkFormValidity();
  });

  emailInput.addEventListener("input", () => {
    isEmailValid = validateEmail(emailInput.value);
    emailError.classList.toggle("hidden", isEmailValid);
    checkFormValidity();
  });

  passwordInput.addEventListener("input", () => {
    isPasswordValid = validatePassword(passwordInput.value);
    passwordError.classList.toggle("hidden", isPasswordValid);
    checkFormValidity();
  });

  confirmPassword.addEventListener("input", () => {
    if (confirmPassword.value !== passwordInput.value) {
      confirmPasswordError.classList.remove("hidden");
    } else {
      confirmPasswordError.classList.add("hidden");
    }
  });

  function clearError(input) {
    input.id === 'email' ? emailError.classList.add('hidden') : input.id === 'password' ? passwordError.classList.add('hidden') : confirmPasswordError.classList.add('hidden');
  }

  const form = document.getElementById("registerForm");

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    if (!isEmailValid || !isPasswordValid || confirmPassword.value !== passwordInput.value) {
      alert('Por favor, complete correctamente el formulario');
      return;
    }

    axios.post('/auth/register', {
      email: emailInput.value,
      password: passwordInput.value,
      name: nameInput.value
    })
      .then(({ data }) => {
        const formatJson = JSON.parse(data);
        if (formatJson.isRegister) {
          window.location.href = '/login';
        } else {
          alert('Error');
        }
      })
      .catch(error => console.error(error));

  });

</script>