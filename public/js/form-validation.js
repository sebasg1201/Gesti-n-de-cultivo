/**
 * AgriControl - Global Real-Time Form Validation
 *
 * Reglas:
 *  - NIT:    solo números, 9-12 dígitos
 *  - Cédula: solo números, 6-10 dígitos (Max 10 si empieza por 1000000000)
 *  - Email:  formato válido usuario@dominio.com
 *  - Teléfono: solo números, 7-10 dígitos
 *  - Contraseña: mínimo 8 caracteres
 *  - Nombre Representante: solo letras y espacios
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
    if (n === 'nombre_repre_legal' || id === 'nombre_repre_legal') {
        return 'nombre_repre';
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

    // Nombre de Empresa
    if (n === 'nombre_empresa' || id === 'nombre_empresa' || n.includes('nombre_empresa')) {
        return 'nombre_empresa';
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
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const regexText = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s.&]+$/;

    switch (fieldType) {
        case 'nit':
            if (!regexNum.test(value)) {
                isValid = false; errorMessage = 'Solo debe contener números.';
            } else if (value.length < 9 || value.length > 12) {
                isValid = false; errorMessage = 'El NIT debe tener entre 9 y 12 dígitos.';
            }
            break;

        case 'cedula':
            if (!regexNum.test(value)) {
                isValid = false;
                errorMessage = 'Solo debe contener números.';
                break;
            }

            const len = value.length;
            const num = Number(value);

            // No permitir que empiece en 0
            if (value.startsWith('0')) {
                isValid = false;
                errorMessage = 'La cédula no puede empezar en 0.';
                break;
            }

            // Cédulas antiguas (6 a 9 dígitos)
            if (len >= 6 && len <= 9) {

                // Evitar números irreales demasiado altos
                if (num >= 1000000000) {
                    isValid = false;
                    errorMessage = 'Número de cédula inválido.';
                    break;
                }

                // Opcional: límite más realista
                if (num > 150000000) {
                    isValid = false;
                    errorMessage = 'Número de cédula fuera de rango válido.';
                    break;
                }

                break; // válida
            }

            // Cédulas nuevas (exactamente 10 dígitos)
            if (len === 10) {

                if (!value.startsWith('1')) {
                    isValid = false;
                    errorMessage = 'Las cédulas de 10 dígitos deben empezar por 1.';
                    break;
                }

                if (num < 1000000000) {
                    isValid = false;
                    errorMessage = 'Número de cédula inválido.';
                    break;
                }

                break; // válida
            }

            // ❌ Cualquier otro caso
            isValid = false;
            errorMessage = 'La cédula debe tener entre 6 y 10 dígitos.';
            break;

        case 'email': {
            // Regex profesional: local válido + dominio real + TLD mínimo 2 letras
            // Rechaza: a@b.c, @domain.com, user@.com, user@domain., etc.
            const regexEmailPro = /^[a-zA-Z0-9][a-zA-Z0-9._%+\-]*[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9.\-]*[a-zA-Z0-9]\.[a-zA-Z]{2,}$/;
            // También validar longitudes mínimas razonables
            const emailParts = value.split('@');
            const localOk = emailParts.length === 2 && emailParts[0].length >= 2;
            const domainParts = emailParts.length === 2 ? emailParts[1].split('.') : [];
            const domainOk = domainParts.length >= 2 && domainParts[0].length >= 2 && domainParts[domainParts.length - 1].length >= 2;
            if (!regexEmailPro.test(value) || !localOk || !domainOk) {
                isValid = false; errorMessage = 'Correo inválido. Ej: usuario@empresa.com (dominio debe tener al menos 2 letras).';
            }
            break;
        }

        case 'telefono':
            if (!regexNum.test(value)) {
                isValid = false; errorMessage = 'Solo debe contener números.';
            } else if (value.length < 7 || value.length > 10) {
                isValid = false; errorMessage = 'El teléfono debe tener entre 7 y 10 dígitos.';
            }
            break;

        case 'password':
            if (value.length < 8) {
                isValid = false; errorMessage = 'La contraseña debe tener mínimo 8 caracteres.';
            }
            break;

        case 'nombre_empresa':
            if (!regexText.test(value)) {
                isValid = false;
                errorMessage = 'El nombre de la empresa solo debe contener letras, espacios O (.)(&)';
            } else if (value.length > 100) {
                isValid = false;
                errorMessage = 'Máximo 100 caracteres.';
            }
            break;

        case 'nombre_licencia':
            if (!regexText.test(value)) {
                isValid = false; errorMessage = 'El nombre solo debe contener letras y espacios.';
            } else if (value.length > 100) {
                isValid = false; errorMessage = 'Máximo 100 caracteres.';
            }
            break;

        case 'tiempo':
            if (value.length > 50) {
                isValid = false; errorMessage = 'Máximo 50 caracteres.';
            } else if (!/^[a-zA-Z0-9\sñÑáéíóúÁÉÍÓÚ]+$/.test(value)) {
                isValid = false; errorMessage = 'Solo letras, números y espacios.';
            }
            break;

        case 'precio':
            if (isNaN(value) || Number(value) <= 0) {
                isValid = false; errorMessage = 'Ingresa un precio válido mayor a 0.';
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