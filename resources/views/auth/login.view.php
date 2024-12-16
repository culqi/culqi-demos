<?php
$title = 'Login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $emailIsValid = filter_var($email, FILTER_VALIDATE_EMAIL);
  $passwordIsValid = strlen($password) >= 8;

  if ($emailIsValid && $passwordIsValid) {
    // Procesa el login
    echo "Login successful!";
  } else {
    // Retorna errores al usuario
    echo "Invalid input.";
  }
}
?>

<div class="flex items-center justify-center">
  <div class="w-full max-w-md">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="loginForm" method="POST">
      <h2 class="text-center text-2xl font-bold mb-6">Login</h2>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
          Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email"
          placeholder="Email" required>
        <p class="text-red-500 text-xs hidden" id="emailError">Email invalido</p>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Contraseña
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password"
          placeholder="******************" required>
        <p class="text-red-500 text-xs hidden" id="passwordError">La contraseña debe tener al menos 8 caracteres</p>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" id="submitButton" disabled>
          Iniciar Sesión
        </button>
      </div>
    </form>
  </div>
</div>
<script>
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const emailError = document.getElementById('emailError');
  const passwordError = document.getElementById('passwordError');
  const submitButton = document.getElementById('submitButton');

  emailInput.addEventListener('input', () => {
    if (!emailInput.checkValidity()) {
      emailError.classList.remove('hidden');
    } else {
      emailError.classList.add('hidden');
    }
    submitButton.disabled = !emailInput.checkValidity() || !passwordInput.checkValidity();
  });

  passwordInput.addEventListener('input', () => {
    if (passwordInput.value.length < 8) {
      passwordError.classList.remove('hidden');
    } else {
      passwordError.classList.add('hidden');
    }
    submitButton.disabled = !emailInput.checkValidity() || !passwordInput.checkValidity();
  });

  const form = document.getElementById('loginForm');

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = Object.fromEntries(new FormData(form));

    axios.post('/auth/login', formData)
      .then(({ data }) => {
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