export function PlanV(name, short_name, description, currency, amount, interval_count, initial_cycles, interval_unit_time, pay_info) {
    // Validar que solo contengan caracteres alfanuméricos (sin espacios)
    const alphanumericPattern = /^[a-zA-Z0-9\s]+$/; // Permitir letras, números y espacios
    if (!alphanumericPattern.test(name)) {
        return { error: "Error: 'name' solo puede contener caracteres alfanuméricos." };
    }
    if (!alphanumericPattern.test(short_name)) {
        return { error: "Error: 'short_name' solo puede contener caracteres alfanuméricos." };
    }
    if (!alphanumericPattern.test(description)) {
        return { error: "Error: 'description' solo puede contener caracteres alfanuméricos." };
    }

    // Validar que los campos no estén vacíos
    if (!name || !short_name || !description || !currency || !amount || !interval_count || !initial_cycles || !interval_unit_time || !pay_info) {
        return { error: "Error: Faltan campos obligatorios." };
    }

    // Validar que amount esté en el rango de 300 a 50,000,000
    if (amount < 300 || amount > 50000000) {
        return { error: "El campo 'amount' admite valores en el rango 300 a 50000000." };
    }

    // Validar que interval_count e initial_cycles sean enteros positivos
    if (!Number.isInteger(Number(interval_count)) || interval_count < 0 ||
        !Number.isInteger(Number(initial_cycles)) || initial_cycles < 0) {
        return { error: "Error: interval_count y initial_cycles deben ser enteros positivos." };
    }

    // Si pasa todas las validaciones
    return {};
}

export function CustomerV(f_name, l_name, email, phone, address, address_c, country) {
    // Validar que todos los campos requeridos no estén vacíos
    if (!f_name || !l_name || !email || !phone || !address || !address_c || !country) {
        return { error: "Error: Faltan campos obligatorios." };
    }

    // Validar address: longitud entre 5 y 100 caracteres
    if (address.length < 4 || address.length > 100) {
        return { error: "Error: 'address' La direccion debe tener entre 4 y 100 caracteres." };
    }

    // Validar address_city: longitud entre 2 y 30 caracteres
    if (address_c.length < 2 || address_c.length > 30) {
        return { error: "Error: 'address_c' El distrito debe tener entre 2 y 30 caracteres." };
    }

    // Validar email: formato de correo electrónico
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Formato básico de email
    if (!emailPattern.test(email) || email.length < 5 || email.length > 50) {
        return { error: "Error: 'email' debe ser un correo electrónico válido y tener entre 5 y 50 caracteres." };
    }

    // Validar country_code: solo permite "PE" o "US"
    const validCountryCodes = ["PE", "US"];
    if (!validCountryCodes.includes(country)) {
        return { error: "Error: 'country' EL codigo de país debe ser 'PE' o 'US'." };
    }

    // Validar first_name: solo texto, máximo 50 caracteres
    const namePattern = /^[A-Za-zÀ-ÿ\s]{2,50}$/; // Permitir letras y espacios
    if (!namePattern.test(f_name)) {
        return { error: "Error: 'f_name' El nombre debe contener solo letras y espacios, y tener entre 2 y 50 caracteres." };
    }

    // Validar last_name: solo texto, máximo 50 caracteres
    if (!namePattern.test(l_name)) {
        return { error: "Error: 'l_name' El apellido debe contener solo letras y espacios, y tener entre 2 y 50 caracteres." };
    }

    // Validar phone_number: solo 9 números y el primero debe ser 9
    const phonePattern = /^9\d{8}$/; // Formato para 9 dígitos, comenzando con 9
    if (!phonePattern.test(phone) || phone.length < 9 || phone.length > 15) {
        return { error: "Error: 'phone' debe comenzar con 9 y contener exactamente 9 dígitos." };
    }

    // Si pasa todas las validaciones
    return {};
}

