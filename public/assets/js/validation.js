document.addEventListener("DOMContentLoaded", () => {
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
});
