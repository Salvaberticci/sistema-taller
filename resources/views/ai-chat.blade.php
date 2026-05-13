<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MecaniSmart AI Assistant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-0 flex flex-col h-[600px]">
                    <!-- Chat Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">Asistente Técnico IA</h3>
                                <p class="text-xs text-blue-100 uppercase tracking-widest font-semibold">Potenciado por Llama 3</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                            <span class="text-xs font-medium">Online</span>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50 dark:bg-gray-900/50">
                        <!-- Bot Welcome Message -->
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 dark:text-blue-400 text-xs font-bold">AI</span>
                            </div>
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 dark:border-gray-700 max-w-[80%]">
                                <p class="text-sm text-gray-700 dark:text-gray-300">¡Hola! Soy tu asistente de MecaniSmart. ¿En qué puedo ayudarte hoy? Puedo ayudarte con diagnósticos, búsqueda de piezas o procedimientos técnicos.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="p-6 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
                        <form id="chat-form" class="flex gap-4">
                            @csrf
                            <input type="text" id="user-input" placeholder="Escribe tu consulta técnica aquí..." 
                                class="flex-1 bg-gray-100 dark:bg-gray-900 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-200 transition-all duration-200"
                                required autocomplete="off">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-2xl transition-all duration-200 shadow-lg shadow-blue-500/30 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const chatMessages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');

        function appendMessage(role, content) {
            const div = document.createElement('div');
            div.className = `flex items-start gap-3 ${role === 'user' ? 'flex-row-reverse' : ''}`;
            
            const icon = role === 'user' 
                ? `<div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center flex-shrink-0"><span class="text-gray-600 dark:text-gray-400 text-xs font-bold">ME</span></div>`
                : `<div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0"><span class="text-blue-600 dark:text-blue-400 text-xs font-bold">AI</span></div>`;

            const bubbleClass = role === 'user' 
                ? 'bg-blue-600 text-white rounded-tr-none' 
                : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-tl-none border border-gray-100 dark:border-gray-700';

            div.innerHTML = `
                ${icon}
                <div class="p-4 rounded-2xl shadow-sm max-w-[80%] ${bubbleClass}">
                    <p class="text-sm">${content}</p>
                </div>
            `;
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = userInput.value.trim();
            if (!message) return;

            appendMessage('user', message);
            userInput.value = '';
            
            // Loading state
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'flex items-start gap-3 animate-pulse';
            loadingDiv.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-600 dark:text-blue-400 text-xs font-bold">AI</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce [animation-delay:-.3s]"></div>
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce [animation-delay:-.5s]"></div>
                    </div>
                </div>
            `;
            chatMessages.appendChild(loadingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                const response = await fetch('/ai-chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                chatMessages.removeChild(loadingDiv);
                
                if (data.choices && data.choices[0] && data.choices[0].message) {
                    appendMessage('bot', data.choices[0].message.content);
                } else {
                    appendMessage('bot', 'Lo siento, hubo un error al procesar tu solicitud.');
                }
            } catch (error) {
                chatMessages.removeChild(loadingDiv);
                appendMessage('bot', 'Error de conexión con el servidor.');
            }
        });
    </script>
</x-app-layout>
