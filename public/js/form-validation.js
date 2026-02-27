/**
 * AgriControl - Global Real-Time Form Validation
 * Estándares Profesionales Colombia (2024)
 *
 * Reglas:
 *  - NIT:              Solo números, exactamente 9 dígitos (DIAN Colombia), no empieza en 0
 *  - Nombre Empresa:   Solo letras/espacios/(&.SAS), mínimo 2 palabras reales, máx 100 chars
 *  - Cédula Repre:     Solo números, 6-10 dígitos, no empieza en 0
 *  - Representante:    Solo letras y espacios (sin números ni especiales), mínimo 3 letras, mínimo 2 palabras
 *  - Teléfono:         Solo números, exactamente 7 dígitos (fijo local) o 10 dígitos (celular/fijo nacional)
 *  - Email:            Formato válido usuario@dominio.ext (dominio real, TLD >= 2 letras)
 *  - Dirección:        Mínimo 5 caracteres, formato real (letras + números)
 *  - Contraseña:       Mínimo 8 caracteres
 *
 * Para detectar el tipo de campo se usa tanto el `name` como el `id` del input.
 * Los campos sin regla especial solo se validan como "requerido / no requerido".
 */
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.validate-form');

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        const submitBtn = form.querySelector('button[type="submit"]');

        const checkFormValidity = () => {
            let formIsValid = true;
            inputs.forEach(input => {
                if (shouldSkip(input)) return;
                // No es válido si falla formato local O si la validación asíncrona falló O está en curso
                if (!validateField(input, false) || input.dataset.asyncValid === 'false' || input.dataset.asyncChecking === 'true') {
                    formIsValid = false;
                }
            });

            if (submitBtn) {
                submitBtn.disabled = !formIsValid;
                submitBtn.classList.toggle('opacity-50', !formIsValid);
                submitBtn.classList.toggle('cursor-not-allowed', !formIsValid);
            }
        };

        inputs.forEach(input => {
            if (shouldSkip(input)) return;

            ['input', 'change', 'blur'].forEach(event => {
                input.addEventListener(event, () => {
                    const isValidLocal = validateField(input, true);
                    if (isValidLocal) {
                        triggerAsyncValidation(input, checkFormValidity);
                    } else {
                        // Reset asíncrono si el formato local falla
                        input.dataset.asyncValid = 'true';
                        input.dataset.asyncChecking = 'false';
                    }
                    checkFormValidity();
                });
            });
        });

        form.addEventListener('submit', (e) => {
            let formIsValid = true;
            inputs.forEach(input => {
                if (shouldSkip(input)) return;
                if (!validateField(input, true) || input.dataset.asyncValid === 'false') {
                    formIsValid = false;
                }
            });
            if (!formIsValid) e.preventDefault();
        });

        checkFormValidity();
    });
});

let debounceTimers = {};

const triggerAsyncValidation = (input, onComplete) => {
    const type = getFieldType(input);
    const fieldMapping = {
        'nit': 'id_empresa',
        'nombre_empresa': 'nombre_empresa',
        'cedula': 'cedula_repre',
        'telefono': 'telefono',
        'email': 'correo'
    };

    const fieldName = fieldMapping[type];
    if (!fieldName) return;

    const value = input.value.trim();
    if (value.length < 3) return; // Mínimo de caracteres para disparar búsqueda asíncrona

    if (debounceTimers[fieldName]) clearTimeout(debounceTimers[fieldName]);
    debounceTimers[fieldName] = setTimeout(async () => {
        await checkUniquenessFromServer(input, fieldName, value);
        if (onComplete) onComplete();
    }, 500);
};

const checkUniquenessFromServer = async (input, field, value) => {
    input.dataset.asyncChecking = 'true';
    updateUI(input, 'checking', 'Verificando disponibilidad...');

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        const response = await fetch('/validar-unicidad', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ field, value })
        });

        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        const data = await response.json();
        input.dataset.asyncChecking = 'false';

        if (data.exists) {
            input.dataset.asyncValid = 'false';
            updateUI(input, false, data.message);
        } else {
            input.dataset.asyncValid = 'true';
            updateUI(input, true, '');
        }
    } catch (error) {
        console.error('Error validando:', error);
        input.dataset.asyncChecking = 'false';

        // En caso de error técnico (419, 500), no marcamos como verde ni rojo 
        // para no dar falsa sensación de seguridad ni bloquear al usuario.
        // Lo dejamos en estado neutral o permitimos si es vital.
        input.dataset.asyncValid = 'true';
        updateUI(input, null, '');
    }
};

/* -----------------------------------------------------------------------
   Helpers
----------------------------------------------------------------------- */

function shouldSkip(input) {
    return input.type === 'hidden' || input.type === 'file' || input.readOnly;
}

/**
 * Devuelve el tipo semántico del campo basándose en name e id.
 * Retorna: 'nit' | 'cedula' | 'email' | 'telefono' | 'password' | 'nombre_repre' | null
 */
function getFieldType(input) {
    const n = (input.name || '').toLowerCase();
    const id = (input.id || '').toLowerCase();

    // NIT / ID de empresa (no cédula)
    // Palabras clave: nit, id_empresa, empresa_nit
    if (n === 'nit' || id === 'nit'
        || n.includes('_nit') || id.includes('_nit')
        || n === 'id_empresa' || id === 'id_empresa'
        || n === 'empresa_nit' || id === 'empresa_nit'
        || n.startsWith('nit') || id.startsWith('nit')) {
        return 'nit';
    }

    // Cédula / Documento de identidad
    // Palabras clave: cedula, documento, cedula_repre, admin_documento
    if (n.includes('cedula') || id.includes('cedula')
        || n.includes('documento') || id.includes('documento')) {
        return 'cedula';
    }

    // Email
    if (n.includes('correo') || n.includes('email')
        || id.includes('correo') || id.includes('email')
        || input.type === 'email') {
        return 'email';
    }

    // Teléfono
    if (n.includes('telefono') || n.includes('celular')
        || id.includes('telefono') || id.includes('celular')) {
        return 'telefono';
    }

    // Contraseña
    if (n.includes('password') || n.includes('contrasena')
        || id.includes('password')
        || input.type === 'password') {
        return 'password';
    }

    // Nombre solo letras (representante legal)
    if (n === 'nombre_repre_legal' || id === 'nombre_repre_legal'
        || n.includes('representante') || id.includes('representante')
        || n.includes('repre_legal') || id.includes('repre_legal')) {
        return 'nombre_repre';
    }

    // Nombre de Empresa
    if (n === 'nombre_empresa' || id === 'nombre_empresa' || n.includes('nombre_empresa')) {
        return 'nombre_empresa';
    }

    // Dirección
    if (n.includes('direccion') || n.includes('direccion') || n === 'direccion'
        || id.includes('direccion') || id === 'direccion') {
        return 'direccion';
    }

    // Nombre de Licencia
    if (n === 'nombre_licencia' || id === 'nombre_licencia') {
        return 'nombre_licencia';
    }

    // Tiempo de Duración
    if (n === 'tiempo' || id === 'tiempo') {
        return 'tiempo';
    }

    // Precio / Valor
    if (n === 'precio' || id === 'precio' || n.includes('precio') || id.includes('precio')
        || n === 'valor' || id === 'valor') {
        return 'precio';
    }

    return null;
}

/**
 * Valida un campo individual.
 * @param {HTMLInputElement} input
 * @param {boolean} showUI  Si true, pinta el borde y muestra/quita mensaje de error.
 * @returns {boolean}
 */
function validateField(input, showUI) {
    if (shouldSkip(input)) return true;

    let value = input.value.trim();
    const isRequired = input.hasAttribute('required');
    const fieldType = getFieldType(input);

    let isValid = true;
    let errorMessage = '';

    // --- 1. Campo vacío ---
    if (value === '') {
        if (isRequired) {
            isValid = false;
            errorMessage = 'Este campo es obligatorio.';
        }
        // Si es opcional y está vacío → estado neutral, no error
        if (showUI) updateUI(input, isRequired ? false : null, errorMessage);
        return isValid;
    }

    // --- 2. Reglas según tipo de campo ---
    const regexNum = /^\d+$/;
    const regexSoloLetras = /^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/;         // Solo letras + espacios (sin números ni especiales)
    const regexEmpresa = /^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s.&]+$/;       // Empresa: letras, espacios, punto, ampersand
    const regexText = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s.&]+$/;

    switch (fieldType) {

        // ── NIT ────────────────────────────────────────────────────────────
        // Colombia (DIAN): exactamente 9 dígitos, no empieza en 0
        case 'nit': {
            if (!regexNum.test(value)) {
                isValid = false;
                errorMessage = 'El NIT solo debe contener números, sin guiones ni puntos.';
            } else if (!(value.startsWith('8') || value.startsWith('9'))) {
                isValid = false;
                errorMessage = 'El NIT debe iniciar con 8 o 9.';
            } else if (value.length !== 9) {
                isValid = false;
                errorMessage = `El NIT debe tener exactamente 9 dígitos. Actualmente tienes ${value.length}.`;
            } else if (/^(\d)\1+$/.test(value)) {
                isValid = false;
                errorMessage = 'El NIT no puede tener todos los dígitos iguales.';
            }
            break;
        }

        // ── CÉDULA Representante ───────────────────────────────────────────
        case 'cedula': {

            if (!/^\d+$/.test(value)) {
                isValid = false;
                errorMessage = 'La cédula solo debe contener números.';
                break;
            }

            if (value.startsWith('0')) {
                isValid = false;
                errorMessage = 'La cédula no puede iniciar en 0.';
                break;
            }

            // Evitar números repetidos (1111111111, 222222, etc.)
            if (/^(\d)\1+$/.test(value)) {
                isValid = false;
                errorMessage = 'Número de cédula inválido.';
                break;
            }

            // Evitar secuencias obvias (123456, 987654, etc.)
            if (/123456|234567|345678|456789/.test(value) || /987654|876543|765432|654321/.test(value)) {
                isValid = false;
                errorMessage = 'Número de cédula inválido.';
                break;
            }

            const len = value.length;

            // 6 a 9 dígitos → válidas
            if (len >= 6 && len <= 9) {
                break;
            }

            // 10 dígitos → deben empezar en 1
            if (len === 10) {
                if (!value.startsWith('1')) {
                    isValid = false;
                    errorMessage = 'Las cédulas de 10 dígitos deben iniciar en 1.';
                    break;
                }
                break;
            }

            isValid = false;
            errorMessage = 'La cédula debe tener entre 6 y 10 dígitos.';
            break;
        }
        // ── NOMBRE EMPRESA ─────────────────────────────────────────────────
        // Mínimo 2 palabras reales (nombre + razón/sigla), solo letras/espacios/(&.)
        case 'nombre_empresa': {
            if (!regexEmpresa.test(value)) {
                isValid = false;
                errorMessage = 'El nombre de la empresa no puede contener números ni caracteres especiales.';
                break;
            }

            const palabras = value.trim().toLowerCase().split(/\s+/);

            if (palabras.length < 2) {
                isValid = false;
                errorMessage = 'El nombre debe contener al menos 2 palabras.';
                break;
            }

            if (palabras.some(p => p.length < 3)) {
                isValid = false;
                errorMessage = 'Cada palabra debe tener al menos 3 letras.';
                break;
            }

            // Función para detectar palabras sospechosas
            const esPalabraBasura = (p) => {
                // Sin vocales
                if (!/[aeiouáéíóú]/.test(p)) return true;

                // Repeticiones exageradas
                if (/(.)\1{3,}/.test(p)) return true;

                // Muy larga sin sentido (más de 12 letras)
                if (p.length > 12) return true;

                // Baja variedad de letras (ej: asdasdasd)
                const letrasUnicas = new Set(p).size;
                if (letrasUnicas <= 3 && p.length > 5) return true;

                return false;
            };

            if (palabras.some(p => esPalabraBasura(p))) {
                isValid = false;
                errorMessage = 'El nombre contiene palabras no válidas.';
                break;
            }

            if (value.length < 5) {
                isValid = false;
                errorMessage = 'El nombre es demasiado corto.';
                break;
            }

            if (value.length > 50) {
                isValid = false;
                errorMessage = 'El nombre no puede superar los 50 caracteres.';
                break;
            }

            break;
        }

        // ── REPRESENTANTE LEGAL ────────────────────────────────────────────
        // Solo letras y espacios, sin números ni especiales, mínimo 2 palabras con ≥ 3 letras c/u
        case 'nombre_repre': {
            // Solo letras y espacios (nada de puntos, números ni símbolos)
            if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/.test(value)) {
                isValid = false;
                errorMessage = 'El nombre solo puede contener letras y espacios. No se permiten caracteres especiales.';
                break;
            }

            const palabras = value.trim().toLowerCase().split(/\s+/);

            // 1. Mínimo 2 palabras (nombre + apellido)
            if (palabras.length < 2) {
                isValid = false;
                errorMessage = 'Debe ingresar al menos nombre y apellido.';
                break;
            }

            // 2. Cada palabra mínimo 3 letras
            if (palabras.some(p => p.length < 3)) {
                isValid = false;
                errorMessage = 'Cada nombre o apellido debe tener al menos 3 letras.';
                break;
            }

            // 3. Evitar palabras sin vocales (ej: "sss", "qwrty")
            const tieneVocal = p => /[aeiouáéíóú]/.test(p);
            if (palabras.some(p => !tieneVocal(p))) {
                isValid = false;
                errorMessage = 'El nombre contiene palabras no válidas.';
                break;
            }

            // 4. Evitar repeticiones exageradas (ej: "aaaa", "ssss")
            if (palabras.some(p => /(.)\1{2,}/.test(p))) {
                isValid = false;
                errorMessage = 'El nombre contiene repeticiones inválidas.';
                break;
            }

            // 5. Evitar patrones tipo teclado (asdf, qwerty)
            const patronesFake = ['asdf', 'qwerty', 'zxcv', 'asdfg', 'qwert', 'abcde'];
            if (palabras.some(p => patronesFake.includes(p))) {
                isValid = false;
                errorMessage = 'El nombre no parece válido.';
                break;
            }

            // 6. Mínimo 3 letras en total (sin contar espacios)
            if (value.replace(/\s/g, '').length < 3) {
                isValid = false;
                errorMessage = 'El nombre debe tener al menos 3 letras.';
                break;
            }

            // 7. Máximo 50 caracteres
            if (value.length > 50) {
                isValid = false;
                errorMessage = 'El nombre no puede superar los 50 caracteres.';
                break;
            }

            break;
        }

        // ── EMAIL ──────────────────────────────────────────────────────────
        case 'email': {
            const regexEmailPro = /^[a-zA-Z0-9][a-zA-Z0-9._%+\-]*[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9.\-]*[a-zA-Z0-9]\.[a-zA-Z]{2,}$/;

            if (!regexEmailPro.test(value)) {
                isValid = false;
                errorMessage = 'Correo inválido. Ej: usuario@empresa.com';
                break;
            }

            const [local, domain] = value.split('@');

            // 🔹 Validar longitud mínima
            if (local.length < 3) {
                isValid = false;
                errorMessage = 'El correo es demasiado corto.';
                break;
            }

            // 🔹 Detectar patrones sospechosos (asdf, qwer, etc.)
            if (/^[a-z]{6,}$/.test(local)) {
                const vocales = local.match(/[aeiou]/gi) || [];
                const porcentajeVocales = vocales.length / local.length;

                if (porcentajeVocales < 0.3) {
                    isValid = false;
                    errorMessage = 'El correo parece no válido (texto sin sentido).';
                    break;
                }
            }

            // 🔹 Detectar caracteres repetidos (aaaaaa)
            if (/(.)\1{3,}/.test(local)) {
                isValid = false;
                errorMessage = 'El correo no puede tener caracteres repetidos excesivos.';
                break;
            }

            // 🔹 Lista de dominios comunes (para advertencias)
            const dominiosComunes = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];

            if (!dominiosComunes.includes(domain)) {
                // No invalidamos, solo advertimos
                console.warn('Dominio poco común:', domain);
            }

            break;
        }

        // ── TELÉFONO ───────────────────────────────────────────────────────
        // Colombia: 7 dígitos (fijo local sin indicativo) o 10 dígitos (celular o fijo nacional)
        case 'telefono': {

            if (!regexNum.test(value)) {
                isValid = false;
                errorMessage = 'El teléfono solo debe contener números, sin espacios ni guiones.';
                break;
            }

            // ❌ Longitud inválida
            if (value.length !== 10) {
                isValid = false;
                errorMessage = `El teléfono debe tener exactamente 10 dígitos (celular). Actualmente tienes ${value.length}.`;
                break;
            }

            // 📱 CELULAR → obligatorio iniciar en 3
            if (value.length === 10 && !value.startsWith('3')) {
                isValid = false;
                errorMessage = 'El número celular debe iniciar con 3. Ej: 3001234567.';
                break;
            }

            break;
        }

        // ── DIRECCIÓN ─────────────────────────────────────────────────────
        // Mínimo 5 chars, debe tener letras Y números (Ej: "Calle 12 # 34-56")
        case 'direccion': {
            if (value.length < 8) {
                isValid = false;
                errorMessage = 'La dirección es demasiado corta. Ej: "Calle 12 # 34-56".';
                break;
            }

            if (value.length > 150) {
                isValid = false;
                errorMessage = 'La dirección no puede superar los 150 caracteres.';
                break;
            }

            // 🔹 Debe tener letras y números
            if (!/[a-zA-ZñÑáéíóúÁÉÍÓÚ]/.test(value) || !/\d/.test(value)) {
                isValid = false;
                errorMessage = 'La dirección debe contener letras y números. Ej: "Calle 12 # 34-56".';
                break;
            }

            // 🔹 Evitar caracteres repetidos tipo "aaaaaa"
            if (/(.)\1{4,}/.test(value)) {
                isValid = false;
                errorMessage = 'La dirección no puede contener caracteres repetidos excesivos.';
                break;
            }

            // 🔹 Detectar texto basura tipo "asdfasdf"
            const soloLetras = value.replace(/[^a-zA-Z]/g, '');
            if (soloLetras.length >= 6) {
                const vocales = soloLetras.match(/[aeiou]/gi) || [];
                const porcentaje = vocales.length / soloLetras.length;

                if (porcentaje < 0.3) {
                    isValid = false;
                    errorMessage = 'La dirección no parece válida (texto sin sentido).';
                    break;
                }
            }

            // 🔹 Debe tener estructura básica colombiana
            const regexDireccionCol = /(calle|carrera|cra|cl|av|avenida|transversal|diagonal)/i;
            if (!regexDireccionCol.test(value)) {
                isValid = false;
                errorMessage = 'Incluye tipo de vía. Ej: Calle, Carrera, Avenida, etc.';
                break;
            }

            // 🔹 Debe tener símbolo típico (# o -)
            if (!/[#\-]/.test(value)) {
                isValid = false;
                errorMessage = 'La dirección debe incluir formato como "# 34-56".';
                break;
            }

            // Validar formato tipo: Calle 12 # 34-56
            const regexCompleta = /(calle|carrera|cra|cl|av|avenida|transversal|diagonal)\s+\d+\s*#\s*\d+-\d+/i;

            if (!regexCompleta.test(value)) {
                isValid = false;
                errorMessage = 'La dirección debe tener formato completo. Ej: "Calle 12 # 34-56".';
                break;
            }

            break;
        }

        // ── CONTRASEÑA ────────────────────────────────────────────────────
        case 'password':
            if (value.length < 8) {
                isValid = false;
                errorMessage = 'La contraseña debe tener mínimo 8 caracteres.';
            }
            break;

        // ── NOMBRE LICENCIA ───────────────────────────────────────────────
        case 'nombre_licencia':
            if (!regexText.test(value)) {
                isValid = false;
                errorMessage = 'El nombre de licencia solo debe contener letras, números y espacios.';
            } else if (value.length > 100) {
                isValid = false;
                errorMessage = 'Máximo 100 caracteres.';
            }
            break;

        // ── TIEMPO DURACIÓN ───────────────────────────────────────────────
        case 'tiempo':
            if (value.length > 50) {
                isValid = false;
                errorMessage = 'Máximo 50 caracteres.';
            } else if (!/^[a-zA-Z0-9\sñÑáéíóúÁÉÍÓÚ]+$/.test(value)) {
                isValid = false;
                errorMessage = 'Solo letras, números y espacios.';
            }
            break;

        // ── PRECIO ────────────────────────────────────────────────────────
        case 'precio':
            if (isNaN(value) || Number(value) <= 0) {
                isValid = false;
                errorMessage = 'Ingresa un precio válido mayor a 0.';
            }
            break;

        // Sin regla especial → solo requerido (ya chequeado arriba)
        default:
            break;
    }

    if (showUI) updateUI(input, isValid, errorMessage);
    return isValid;
}

/* -----------------------------------------------------------------------
   UI helpers
----------------------------------------------------------------------- */

/**
 * Actualiza el borde del input y el mensaje de error.
 * @param {HTMLInputElement} input
 * @param {boolean|null} isValid  null = estado neutral (campo opcional vacío)
 * @param {string} errorMessage
 */
function updateUI(input, isValid, errorMessage) {
    // --- Bordes ---
    input.classList.remove(
        'border-red-500', 'focus:ring-red-500', 'focus:border-red-500',
        'border-green-500', 'focus:ring-green-500', 'focus:border-green-500',
        'border-blue-500', 'focus:ring-blue-500', 'focus:border-blue-500',
        'border-gray-300'
    );

    if (isValid === null) {
        // Neutral
        input.classList.add('border-gray-300');
        removeErrorMsg(input);
        return;
    }

    if (isValid === 'checking') {
        input.classList.add('border-blue-500', 'focus:ring-blue-500', 'focus:border-blue-500');
        showErrorMsg(input, errorMessage, 'text-blue-500');
        return;
    }

    if (isValid) {
        input.classList.add('border-green-500', 'focus:ring-green-500', 'focus:border-green-500');
        removeErrorMsg(input);
    } else {
        input.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
        showErrorMsg(input, errorMessage, 'text-red-500');
    }
}

/**
 * Muestra el mensaje de error directamente debajo del campo.
 * La estrategia es usar un <p data-for="input-id"> insertado en el mismo
 * contenedor padre del input para evitar conflictos en modales.
 */
function showErrorMsg(input, message, colorClass = 'text-red-500') {
    const errorId = 'v-err-' + (input.id || input.name || Math.random().toString(36).slice(2));
    let errorEl = document.getElementById(errorId);

    if (!errorEl) {
        errorEl = document.createElement('p');
        errorEl.id = errorId;
        errorEl.className = `v-error-msg ${colorClass} text-xs mt-1`;
        // Insertar justo después del input (no del contenedor)
        input.insertAdjacentElement('afterend', errorEl);
    } else {
        // Actualizar clase de color si ya existe
        errorEl.className = `v-error-msg ${colorClass} text-xs mt-1`;
    }

    errorEl.textContent = message;
    errorEl.style.display = 'block';
}

function removeErrorMsg(input) {
    const errorId = 'v-err-' + (input.id || input.name || '');
    const errorEl = document.getElementById(errorId);
    if (errorEl) {
        errorEl.style.display = 'none';
    }
}