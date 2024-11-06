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
    if (!name || !short_name || !description || !currency || !amount || !interval_count || !initial_cycles || !interval_unit_time || !pay_info) {
        return { error: "Error: Faltan campos obligatorios." };
    }
    if (amount < 300 || amount > 50000000) {
        return { error: "El campo 'amount' admite valores en el rango 300 a 50000000." };
    }
    if (!Number.isInteger(Number(interval_count)) || interval_count < 0 ||
        !Number.isInteger(Number(initial_cycles)) || initial_cycles < 0) {
        return { error: "Error: interval_count y initial_cycles deben ser enteros positivos." };
    }
    return {};
}

export function CustomerV(f_name, l_name, email, phone, address, address_c, country) {
    if (!f_name || !l_name || !email || !phone || !address || !address_c || !country) {
        return { error: "Error: Faltan campos obligatorios." };
    }
    if (address.length < 4 || address.length > 100) {
        return { error: "Error: 'address' La direccion debe tener entre 4 y 100 caracteres." };
    }
    if (address_c.length < 2 || address_c.length > 30) {
        return { error: "Error: 'address_c' El distrito debe tener entre 2 y 30 caracteres." };
    }
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Formato básico de email
    if (!emailPattern.test(email) || email.length < 5 || email.length > 50) {
        return { error: "Error: 'email' debe ser un correo electrónico válido y tener entre 5 y 50 caracteres." };
    }
    const validCountryCodes = ["PE", "US"];
    if (!validCountryCodes.includes(country)) {
        return { error: "Error: 'country' EL codigo de país debe ser 'PE' o 'US'." };
    }
    const namePattern = /^[A-Za-zÀ-ÿ\s]{2,50}$/; // Permitir letras y espacios
    if (!namePattern.test(f_name)) {
        return { error: "Error: 'f_name' El nombre debe contener solo letras y espacios, y tener entre 2 y 50 caracteres." };
    }
    if (!namePattern.test(l_name)) {
        return { error: "Error: 'l_name' El apellido debe contener solo letras y espacios, y tener entre 2 y 50 caracteres." };
    }
    const phonePattern = /^9\d{8}$/; // Formato para 9 dígitos, comenzando con 9
    if (!phonePattern.test(phone) || phone.length < 9 || phone.length > 15) {
        return { error: "Error: 'phone' debe comenzar con 9 y contener exactamente 9 dígitos." };
    }

    return {};
}

export function SuscripcionV(data) {
    const requiredFields = ['idPlan', 'idCard'];
    
    // Recorre los campos requeridos y valida cada uno
    for (const field of requiredFields) {
        // Verifica si el campo está vacío
        if (!data[field] || data[field].trim() === '') {
            alert(`El campo ${field} es obligatorio y no puede estar vacío.`);
            return false;
        }

        // Verifica que el campo no tenga más de 25 caracteres
        if (data[field].length > 25) {
            alert(`El campo ${field} no puede tener más de 25 caracteres.`);
            return false;
        }
    }
    
    return true; // Si pasa todas las validaciones
}
