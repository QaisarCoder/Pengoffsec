<div x-data="aiAssistant()" class="fixed bottom-6 right-6 sm:bottom-8 sm:right-8 z-50">
    <!-- Assistant Button -->
    <button
        @click="toggleAssistant()"
        aria-label="Open AI assistant"
        title="Open AI assistant"
        type="button"
        class="w-14 h-14 sm:w-16 sm:h-16 bg-brand-600 text-white rounded-full flex items-center justify-center shadow-lg shadow-brand-600/30 hover:bg-brand-700 hover:scale-105 active:scale-95 transition-all duration-200"
    >
        <svg x-show="!open" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <svg x-cloak x-show="open" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 6l12 12M18 6L6 18" />
        </svg>
    </button>

    <!-- Assistant Panel -->
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity scale-95 translate-y-2"
        x-transition:enter-end="opacity scale-100 translate-y-0"
        class="absolute bottom-20 right-0 w-[calc(100vw-3rem)] sm:w-96 bg-white border border-ink-200 rounded-2xl shadow-card-hover flex flex-col max-h-[80vh] overflow-hidden"
    >
        <!-- Header -->
        <div class="flex justify-between items-center gap-3 px-5 py-4 border-b border-ink-100 bg-ink-50/60">
            <div class="flex items-center gap-2.5 min-w-0">
                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                <h3 class="font-bold text-ink-900 truncate">PengOffSec AI Assistant</h3>
            </div>
            <button @click="toggleAssistant()" class="text-ink-600 hover:text-ink-900 transition shrink-0" aria-label="Close assistant">&times;</button>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-2 bg-white">
            <template x-if="history.length === 0">
                <div class="text-center py-8">
                    <p class="text-sm text-ink-500">Ask about our services, or book a consultation.</p>
                </div>
            </template>
            <template x-for="msg in history" :key="msg.id">
                <div :class="msg.role === 'user' ? 'text-right' : 'text-left'">
                    <span
                        :class="msg.role === 'user' ? 'bg-brand-600 text-white' : 'bg-ink-100 text-ink-700'"
                        class="inline-block p-3 rounded-xl text-sm max-w-[85%] leading-relaxed"
                        x-text="msg.content"
                    ></span>
                </div>
            </template>
            <p x-show="status === 'processing'" class="text-xs text-ink-600">Thinking…</p>
        </div>

        <!-- Error notice -->
        <div x-show="error && status === 'error'" x-cloak class="mx-5 mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-900">
            <p x-text="error"></p>
            <p class="mt-1.5 text-amber-800">
                You can also reach us at
                <a href="/contact" class="font-semibold underline">our contact page</a>.
            </p>
        </div>

        <!-- Booking reference -->
        <div x-show="reference" x-cloak class="mx-5 mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-900">
            <p class="font-semibold">Booking confirmed</p>
            <p class="mt-1">Reference: <span class="font-mono" x-text="reference"></span></p>
        </div>

        <!-- Appointment Details -->
        <div x-show="appointmentState.appointment_intent" x-cloak class="mx-5 mb-4 bg-brand-50 border border-brand-100 rounded-xl p-3 text-xs text-ink-700">
            <h4 class="font-bold text-brand-700 mb-2">Appointment details</h4>
            <div class="grid grid-cols-2 gap-1.5">
                <span class="text-ink-600">Name:</span><span x-text="appointmentState.client_name || '-'"></span>
                <span class="text-ink-600">Service:</span><span x-text="appointmentState.service || '-'"></span>
                <span class="text-ink-600">Date:</span><span x-text="appointmentState.preferred_date || '-'"></span>
                <span class="text-ink-600">Time:</span><span x-text="appointmentState.preferred_time || '-'"></span>
            </div>
        </div>

        <!-- Input Area -->
        <form @submit.prevent="sendTextMessage()" class="px-5 pb-4">
            <div class="flex gap-2">
                <input
                    x-model="textInput"
                    type="text"
                    placeholder="Type your message…"
                    aria-label="Message"
                    class="flex-1 bg-ink-50 text-ink-900 placeholder-ink-600 rounded-full px-4 py-2.5 text-sm border border-ink-200 focus:border-brand-400 focus:ring-4 focus:ring-brand-500/10 outline-none transition"
                >
                <button type="submit" class="bg-brand-600 text-white w-10 h-10 shrink-0 rounded-full flex items-center justify-center hover:bg-brand-700 transition" aria-label="Send message">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

            <div class="flex gap-2 mt-3">
                <button @click="startListening()" x-show="speechSupported && (status === 'idle' || status === 'error')" class="flex-1 btn-primary btn-sm !rounded-full">Listen</button>
                <button @click="stopListening()" x-cloak x-show="status === 'listening'" class="flex-1 btn btn-sm !rounded-full bg-red-500 text-white hover:bg-red-600">Stop</button>
                <button @click="reset()" class="flex-1 btn-secondary btn-sm !rounded-full">Reset</button>
            </div>
        </form>
    </div>
</div>
