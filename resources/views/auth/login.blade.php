<x-guest-layout>
    <style>
        /* === Widget checkbox "No soy un robot" === */
        .captcha-widget {
            display: flex; align-items: center; gap: 12px;
            width: 100%; padding: 14px 16px;
            background: #f9f9f9; border: 1px solid #d3d3d3; border-radius: 4px;
            cursor: pointer; user-select: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box; position: relative;
        }
        .captcha-widget:hover { border-color: #b0b0b0; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .captcha-widget.verified { border-color: #6dc06d; background: #f0f9f0; cursor: default; }
        .captcha-checkbox {
            width: 28px; height: 28px; flex-shrink: 0;
            border: 2px solid #c1c1c1; border-radius: 4px;
            background: #fff; position: relative;
            display: flex; align-items: center; justify-content: center;
            transition: all .25s;
        }
        .captcha-widget.verified .captcha-checkbox { border-color: #6dc06d; background: #6dc06d; }
        .captcha-checkbox-inner { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; position: relative; }
        .captcha-spinner {
            width: 18px; height: 18px; color: #666;
            animation: captcha-spin 1s linear infinite; display: none; position: absolute;
        }
        .captcha-widget.loading .captcha-spinner { display: block; }
        .captcha-check { width: 16px; height: 16px; color: #fff; display: none; }
        .captcha-widget.verified .captcha-check { display: block; }
        @keyframes captcha-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .captcha-label { flex: 1; font-size: 14px; font-weight: 500; color: #555; letter-spacing: .01em; }
        .captcha-brand { display: flex; flex-direction: column; align-items: flex-end; flex-shrink: 0; line-height: 1; }
        .captcha-brand-text { font-size: 11px; font-weight: 700; color: #555; letter-spacing: .02em; }
        .captcha-brand-sub { font-size: 7px; font-weight: 400; color: #999; text-transform: uppercase; letter-spacing: .03em; }

        /* === Modal overlay === */
        .captcha-modal-overlay {
            display: none; position: fixed; z-index: 9999;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,.7); backdrop-filter: blur(4px);
            align-items: center; justify-content: center;
        }
        .captcha-modal-overlay.open { display: flex; }
        .captcha-modal {
            background: #0f172a; border: 1px solid #334155;
            border-radius: 16px; padding: 28px 24px 20px;
            max-width: 340px; width: 90%; box-shadow: 0 25px 60px rgba(0,0,0,.6);
            animation: modal-in .3s ease;
        }
        @keyframes modal-in { from { transform: scale(.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .captcha-modal-prompt {
            text-align: center; font-size: 14px; color: #cbd5e1;
            margin-bottom: 16px; line-height: 1.5;
        }
        .captcha-modal-prompt strong { color: #fbbf24; }
        .captcha-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 6px; max-width: 280px; margin: 0 auto 16px;
        }
        .captcha-cell {
            aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
            background: #1e293b; border: 2px solid #334155; border-radius: 10px;
            cursor: pointer; transition: all .2s; position: relative;
            font-size: 28px; user-select: none;
        }
        .captcha-cell:hover { border-color: #60a5fa; background: #1e3a5f; }
        .captcha-cell.selected { border-color: #22c55e; background: #14532d; }
        .captcha-emoji { line-height: 1; }
        .captcha-cell-check {
            position: absolute; top: 2px; right: 4px;
            font-size: 12px; color: #22c55e; font-weight: bold; display: none;
        }
        .captcha-cell.selected .captcha-cell-check { display: block; }
        .captcha-modal-actions { display: flex; gap: 10px; justify-content: center; }
        .captcha-btn {
            padding: 10px 28px; border: none; border-radius: 8px;
            font-weight: 700; font-size: 14px; cursor: pointer; transition: all .2s;
        }
        .captcha-btn-verify { background: #2563eb; color: #fff; }
        .captcha-btn-verify:hover { background: #1d4ed8; }
        .captcha-btn-cancel { background: #334155; color: #94a3b8; }
        .captcha-btn-cancel:hover { background: #475569; color: #e2e8f0; }
        .captcha-modal-error {
            color: #f87171; font-size: 12px; text-align: center;
            margin-bottom: 10px; font-weight: 500; display: none;
        }
        .captcha-error-msg {
            color: #f87171; font-size: 12px; margin-top: 6px; text-align: center; font-weight: 500;
        }
    </style>

    <div class="min-h-screen flex flex-col md:flex-row bg-[#020617] text-white">
        <!-- Left Side: Image -->
        <div class="hidden md:block md:w-1/2 lg:w-3/5 relative overflow-hidden">
            <img src="{{ asset('images/workshop_background.png') }}" alt="Taller Automotriz" class="absolute inset-0 w-full h-full object-cover filter brightness-[0.6] contrast-[1.1]">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/20 to-[#020617] mix-blend-multiply"></div>
        </div>

        <!-- Right Side: Login -->
        <div class="w-full md:w-1/2 lg:w-2/5 flex flex-col justify-between p-8 sm:p-12 lg:p-16 bg-[#090d1f] border-l border-slate-800/80 shadow-2xl relative z-10">
            <div></div>

            <div class="w-full max-w-md mx-auto my-auto py-8">
                <!-- Logo -->
                <div class="flex flex-col items-center mb-8">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 mb-4 transform -rotate-3 transition-transform hover:rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black italic tracking-widest text-white uppercase text-center">
                        DIOS ES <span class="text-blue-500">AMOR</span>
                    </h2>
                    <p class="text-slate-400 text-xs mt-2 font-medium tracking-wide">Bienvenido a la versión web de nuestro sistema</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-12 pr-4 py-3.5 bg-slate-950/40 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Correo Electrónico">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full pl-12 pr-4 py-3.5 bg-slate-950/40 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Contraseña">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <!-- Widget "No soy un robot" -->
                    <div>
                        <div id="captcha-widget" class="captcha-widget" onclick="openCaptchaModal()">
                            <div class="captcha-checkbox">
                                <div class="captcha-checkbox-inner">
                                    <svg class="captcha-spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" stroke-dasharray="31.4 31.4" stroke-linecap="round"/>
                                    </svg>
                                    <svg class="captcha-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </div>
                            </div>
                            <span class="captcha-label">No soy un robot</span>
                            <div class="captcha-brand">
                                <span class="captcha-brand-text">reCAPTCHA</span>
                                <span class="captcha-brand-sub">by CUSTOM</span>
                            </div>
                        </div>
                        <div id="captcha-error" class="captcha-error-msg" style="display:none">Debes verificar que no eres un robot.</div>
                        <x-input-error :messages="$errors->get('captcha')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center text-slate-400 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-950/40 text-blue-600 focus:ring-blue-500 focus:ring-offset-0">
                            <span class="ml-2 text-xs">Recordarme en este equipo</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl tracking-wider shadow-lg shadow-blue-500/25 transition-all duration-200 active:scale-[0.98] text-sm uppercase">
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Navigation Links -->
                <div class="mt-8 space-y-4 text-center">
                    @if (Route::has('password.request'))
                        <div>
                            <a href="{{ route('password.request') }}" class="text-xs text-slate-400 hover:text-blue-400 transition-colors">
                                ¿Olvidaste tu contraseña o no la has creado?
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="w-full text-center text-[10px] text-slate-600 space-y-1">
                <p>Copyright © 2026 Todos los derechos reservados</p>
                <p class="font-medium opacity-80">v-3.0.165</p>
            </div>
        </div>
    </div>

    <!-- Modal CAPTCHA -->
    <div id="captcha-modal-overlay" class="captcha-modal-overlay" onclick="closeCaptchaModal(event)">
        <div class="captcha-modal" onclick="event.stopPropagation()">
            <p class="captcha-modal-prompt">
                Selecciona todas las imágenes de <strong>{{ $captchaCategory }}</strong>:
            </p>
            <div id="captcha-modal-error" class="captcha-modal-error">Selecciona las imágenes correctas.</div>
            <div class="captcha-grid">
                @foreach ($captchaEmojis as $index => $emoji)
                    <div class="captcha-cell" data-index="{{ $index }}" onclick="toggleCaptchaCell(this)">
                        <span class="captcha-emoji">{{ $emoji }}</span>
                        <span class="captcha-cell-check">✓</span>
                    </div>
                @endforeach
            </div>
            <div class="captcha-modal-actions">
                <button class="captcha-btn captcha-btn-cancel" onclick="closeCaptchaModal(null)">Cancelar</button>
                <button class="captcha-btn captcha-btn-verify" onclick="submitCaptchaVerify()">Verificar</button>
            </div>
        </div>
    </div>

    <script>
        let captchaVerified = false;

        function openCaptchaModal() {
            const widget = document.getElementById('captcha-widget');
            if (widget.classList.contains('verified')) return;
            document.getElementById('captcha-modal-overlay').classList.add('open');
            document.getElementById('captcha-error').style.display = 'none';
        }

        function closeCaptchaModal(e) {
            if (e === null) {
                document.getElementById('captcha-modal-overlay').classList.remove('open');
                return;
            }
            if (e && e.target === e.currentTarget) {
                document.getElementById('captcha-modal-overlay').classList.remove('open');
            }
        }

        function toggleCaptchaCell(cell) {
            cell.classList.toggle('selected');
            document.getElementById('captcha-modal-error').style.display = 'none';
        }

        function submitCaptchaVerify() {
            const selected = document.querySelectorAll('#captcha-modal-overlay .captcha-cell.selected');
            const indices = Array.from(selected).map(el => el.dataset.index);
            const errorEl = document.getElementById('captcha-modal-error');

            if (indices.length === 0) {
                errorEl.textContent = 'Selecciona al menos una imagen.';
                errorEl.style.display = 'block';
                return;
            }

            const widget = document.getElementById('captcha-widget');
            widget.classList.add('loading');

            fetch('{{ route("captcha.verify") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ captcha_indices: indices.join(',') }),
            })
            .then(r => r.json())
            .then(data => {
                widget.classList.remove('loading');
                if (data.success) {
                    captchaVerified = true;
                    widget.classList.add('verified');
                    document.getElementById('captcha-modal-overlay').classList.remove('open');
                    document.getElementById('captcha-error').style.display = 'none';
                } else {
                    errorEl.textContent = data.message || 'Selecciona las imágenes correctas.';
                    errorEl.style.display = 'block';
                }
            })
            .catch(() => {
                widget.classList.remove('loading');
                errorEl.textContent = 'Error de conexión. Intenta de nuevo.';
                errorEl.style.display = 'block';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (!form) return;
            form.addEventListener('submit', function(e) {
                if (!captchaVerified) {
                    e.preventDefault();
                    document.getElementById('captcha-error').style.display = 'block';
                }
            });
        });
    </script>
</x-guest-layout>
