<?php

use App\Config\Config;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = 'Update Customer';
$customer_code = $_SESSION['user']['customer']['customer_code'] ?? '';

$constants = [
    'baseURL' =>   Config::API_BASE_URL,
    'secret_key' => Config::SECRET_KEY,
    'public_key' => Config::PUBLIC_KEY,
];

if (isset($_SESSION['user']['customer'])) {
    $customer = $_SESSION['user']['customer'];
    $customer_details = $_SESSION['user']['customer']['details'];
} else {
    $customer_details = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'address' => '',
        'address_city' => '',
        'country_code' => 'PE',
        'phone_number' => ''
    ];
}
?>
<div class="flex items-center justify-center h-screen">
    <div class="w-full max-w-md">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="settingsForm" method="POST">
            <h2 class="text-center text-2xl font-bold mb-6">Actualizar Detalles del Cliente</h2>

            <!-- First Name -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                    First Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="first_name" name="first_name" type="text" placeholder="First Name"
                    value="<?php echo htmlspecialchars($customer_details['first_name']); ?>" required>
            </div>

            <!-- Last Name -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                    Last Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="last_name" name="last_name" type="text" placeholder="Last Name"
                    value="<?php echo htmlspecialchars($customer_details['last_name']); ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" name="email" type="email" placeholder="Email" value="<?php echo htmlspecialchars($customer_details['email']); ?>"
                    required>
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                    Address
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="address" name="address" type="text" placeholder="Address"
                    value="<?php echo htmlspecialchars($customer_details['address']); ?>" required>
            </div>

            <!-- Address City -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address_city">
                    Address City
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="address_city" name="address_city" type="text" placeholder="City"
                    value="<?php echo htmlspecialchars($customer_details['address_city']); ?>" required>
            </div>

            <!-- Country Code (Dropdown) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="country_code">
                    Country Code
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="country_code" name="country_code" required>
                    <option value="PE" <?php echo ($customer_details['country_code'] === 'PE') ? 'selected' : ''; ?>>Perú (PE)</option>
                    <option value="US" <?php echo ($customer_details['country_code'] === 'US') ? 'selected' : ''; ?>>EE.UU. (US)</option>
                </select>
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_number">
                    Phone Number
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="phone_number" name="phone_number" type="text" placeholder="Phone Number"
                    value="<?php echo htmlspecialchars($customer_details['phone_number']); ?>" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit" id="submitButton" disabled>
                    Crear Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<script type="module">
    const CONSTANTS = <?= json_encode($constants) ?>;
    import Service from './assets/js/services/index.js';

    const firstNameInput = document.getElementById("first_name");
    const lastNameInput = document.getElementById("last_name");
    const emailInput = document.getElementById("email");
    const addressInput = document.getElementById("address");
    const addressCityInput = document.getElementById("address_city");
    const countryCodeInput = document.getElementById("country_code");
    const phoneNumberInput = document.getElementById("phone_number");
    const submitButton = document.getElementById("submitButton");
    const customerCode = "<?php echo htmlspecialchars($customer_code, ENT_QUOTES, 'UTF-8'); ?>";

    if (customerCode.length === 0) alert('debes registrar primero tu Customer ID y tu Customer Email');

    const checkFormValidity = () => {
        submitButton.disabled = !(firstNameInput.value && lastNameInput.value && emailInput.value && addressInput.value && addressCityInput.value &&
            countryCodeInput.value && phoneNumberInput.value);
    };

    firstNameInput.addEventListener("input", checkFormValidity);
    lastNameInput.addEventListener("input", checkFormValidity);
    emailInput.addEventListener("input", checkFormValidity);
    addressInput.addEventListener("input", checkFormValidity);
    addressCityInput.addEventListener("input", checkFormValidity);
    countryCodeInput.addEventListener("change", checkFormValidity);
    phoneNumberInput.addEventListener("input", checkFormValidity);

    const form = document.getElementById("settingsForm");

    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        let customerData = {
            first_name: firstNameInput.value,
            last_name: lastNameInput.value,
            email: emailInput.value,
            address: addressInput.value,
            address_city: addressCityInput.value,
            country_code: countryCodeInput.value,
            phone_number: phoneNumberInput.value
        };

        console.log("Customer Data: ", customerData);

        const service = new Service(CONSTANTS.baseURL);

        const response = await service.createCustomer(customerData, CONSTANTS.secret_key);

        if (response.statusCode === 201) {
            let customerDataFormat = {
                ...customerData,
                customer_code: response.data.id,
                customer_email: response.data.email
            };
            axios.post('/api/customer', customerDataFormat)
                .then((response) => {
                    alert('Cliente registrado en el sistema');
                    window.location.href = '/profile';
                })
                .catch(error => {
                    alert(error.response.data.merchant_message);
                });
        } else {
            alert(response.data.merchant_message);
        }
    });
</script>