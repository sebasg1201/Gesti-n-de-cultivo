<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Seguridad - AgriControl</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.4s ease-in-out 0s 2;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-6 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] overflow-x-hidden">
    <div class="max-w-md w-full">
        {{-- Card Container --}}
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-emerald-100/50 overflow-hidden border border-emerald-50/50 relative">
            
            {{-- Decorative Elements --}}
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-60"></div>

            <div class="p-10 relative z-10">
                {{-- Header --}}
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 rounded-3xl mb-6 shadow-inner">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Verificación</h1>
                    <p class="text-slate-500 font-medium text-sm">Ingresa el código de 6 dígitos que enviamos a tu correo.</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl animate-shake">
                        @foreach($errors->all() as $error)
                            <p class="text-red-700 text-[13px] font-bold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $error }}
                            </p>
                        @endforeach
                    </div>
                @endif

                <div id="resend-success" class="hidden mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl">
                    <p class="text-emerald-700 text-[13px] font-bold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Código reenviado con éxito.
                    </p>
                </div>

                <form method="POST" action="{{ route('login.verify.submit') }}" class="space-y-8">
                    @csrf
                    <div class="relative">
                        <label for="code" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 mb-2 block text-center">Código de Acceso Seguro</label>
                        <input type="text" 
                               name="code" 
                               id="code" 
                               required 
                               maxlength="6"
                               autofocus
                               autocomplete="one-time-code"
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-5 px-6 text-center text-4xl font-black tracking-[0.8rem] text-emerald-600 focus:outline-none focus:border-emerald-500 focus:bg-white transition-all placeholder:text-slate-200"
                               placeholder="000000">
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-emerald-200 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        <span>Verificar y Acceder</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-slate-400 font-bold text-xs mb-4 uppercase tracking-widest">¿No recibiste el código?</p>
                    <button type="button" 
                            onclick="resendCode()" 
                            id="resend-btn"
                            class="text-emerald-600 font-black text-sm uppercase tracking-widest hover:text-emerald-700 transition-colors flex items-center gap-2 mx-auto disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Reenviar Código</span>
                    </button>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-50">
                    <a href="{{ route('usuario.login') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest hover:text-slate-600 flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Volver al Inicio de Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function resendCode() {
            const btn = document.getElementById('resend-btn');
            const successAlert = document.getElementById('resend-success');
            
            btn.disabled = true;
            
            fetch('{{ route("login.resend") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    successAlert.classList.remove('hidden');
                    setTimeout(() => successAlert.classList.add('hidden'), 5000);
                } else {
                    alert('Error: ' + (data.error || 'No se pudo reenviar el código.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error crítico al conectar con el servidor.');
            })
            .finally(() => {
                // Re-enable after 30 seconds to prevent spam
                setTimeout(() => {
                    btn.disabled = false;
                }, 30000);
            });
        }

        // Auto-focus and handling code input
        const codeInput = document.getElementById('code');
        codeInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
