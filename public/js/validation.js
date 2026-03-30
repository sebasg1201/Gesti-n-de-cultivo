document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            // Validate on input
            input.addEventListener('input', function () {
                validateField(input);
            });

            // Validate on blur
            input.addEventListener('blur', function () {
                validateField(input);
            });
        });

        form.addEventListener('submit', function (e) {
            let isFormValid = true;
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isFormValid = false;
                }
            });

            if (!isFormValid) {
                e.preventDefault();
                alert('Por favor, corrige los errores en el formulario antes de enviar.');
            }
        });
    });

    function validateField(input) {
        const name = input.name;
        const value = input.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Reset state
        input.classList.remove('border-red-500', 'ring-red-500');
        const existingError = input.parentElement.querySelector('.js-error-msg');
        if (existingError) existingError.remove();

        // Required check
        if (input.hasAttribute('required') && value === '') {
            isValid = false;
            errorMessage = 'Este campo es obligatorio.';
        }

        // Email check
        if (isValid && input.type === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@gmail\.com$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Ingresa un correo @gmail.com válido (evita errores como "gmial").';
            }
        }

        // Numeric/NIT check (based on name or id)
        if (isValid && (name.includes('nit') || name.includes('documento') || name.includes('telefono')) && value !== '') {
            if (!/^\d+$/.test(value)) {
                isValid = false;
                errorMessage = 'Solo se permiten números.';
            } else if (name.includes('telefono')) {
                if (value.length !== 10) {
                    isValid = false;
                    errorMessage = 'El teléfono debe tener exactamente 10 dígitos.';
                } else if (!value.startsWith('3')) {
                    isValid = false;
                    errorMessage = 'El teléfono debe empezar por el número 3.';
                }
            }
        }

        // Password check
        if (isValid && input.type === 'password' && value !== '' && name === 'contrasena') {
            if (value.length < 8) {
                isValid = false;
                errorMessage = 'La contraseña debe tener al menos 8 caracteres.';
            }
        }

        // Seed Type check (no numbers)
        if (isValid && name === 'Tipo_semilla' && value !== '') {
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u.test(value)) {
                isValid = false;
                errorMessage = 'Solo se permiten letras y espacios.';
            }
        }

        if (!isValid) {
            input.classList.add('border-red-500', 'ring-red-500');
            const errorSpan = document.createElement('span');
            errorSpan.className = 'js-error-msg text-red-500 text-xs mt-1 block';
            errorSpan.innerText = errorMessage;
            input.parentElement.appendChild(errorSpan);
        }

        return isValid;
    }
});
