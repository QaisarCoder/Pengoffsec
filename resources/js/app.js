import './bootstrap';
import * as THREE from 'three';
import gsap from 'gsap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.THREE = THREE;
window.gsap = gsap;

Alpine.data('aiAssistant', () => ({
    open: false,
    status: 'idle',
    speechSupported: true,
    transcript: '',
    reply: '',
    error: null,
    reference: null,
    textInput: '',
    recognition: null,
    history: [],
    conversationId: null,
    appointmentState: {
        appointment_intent: false,
        client_name: null,
        client_email: null,
        client_phone: null,
        service: null,
        preferred_date: null,
        preferred_time: null,
        requirements: null,
        confirmation_status: false
    },

    init() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!SpeechRecognition) {
            this.speechSupported = false;
            return;
        }

        this.speechSupported = true;
        this.recognition = new SpeechRecognition();
        this.recognition.lang = 'en-US';
        this.recognition.continuous = false;
        this.recognition.interimResults = false;

        this.recognition.onstart = () => {
            // Barge-in: if currently speaking, cancel TTS and become listening
            if (this.status === 'speaking') {
                window.speechSynthesis.cancel();
            }
            this.status = 'listening';
        };

        this.recognition.onend = () => {
            // Only revert to idle if we aren't already processing or in error
            if (this.status === 'listening') {
                this.status = 'idle';
            }
        };

        this.recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            this.transcript = transcript;
            this.processQuery();
        };

        this.recognition.onerror = (event) => {
            const code = event.error;
            this.status = 'error';

            if (code === 'not-allowed' || code === 'service-not-allowed') {
                this.error = 'Microphone access was blocked. Please allow it, or type your message instead.';
            } else if (code === 'no-speech') {
                this.error = "I didn't catch that. Please try again, or type your message.";
            } else {
                this.error = 'Voice input failed. Please type your message instead.';
            }

            this.reply = this.error;
        };
    },

    toggleAssistant() {
        this.open = !this.open;
        if (!this.open) this.reset();
    },

    startListening() {
        if (this.status === 'processing') return;

        if (this.recognition) {
            this.reply = '';
            this.error = null;
            this.transcript = '';
            try {
                this.recognition.start();
            } catch (e) {
                console.error('Start recognition failed:', e);
                this.status = 'error';
                this.error = 'Could not start the microphone. Please type your message instead.';
                this.reply = this.error;
            }
        } else {
            this.status = 'error';
            this.error = 'Speech recognition is not available in this browser. Please type your message.';
            this.reply = this.error;
        }
    },

    stopListening() {
        if (this.recognition) {
            try {
                this.recognition.stop();
            } catch { /* already stopped */ }
            this.status = this.status === 'listening' ? 'idle' : this.status;
        }
    },

    sendTextMessage() {
        if (this.status === 'processing') return;
        const text = this.textInput.trim();
        if (!text) return;
        this.textInput = '';
        this.transcript = text;
        this.processQuery();
    },

    async processQuery() {
        // Guard against a second in-flight request (double submit, speech + typed
        // input, rapid Enter presses) which previously duplicated the message.
        if (this.status === 'processing') return;

        const query = (this.transcript || '').trim();
        if (!query) return;

        this.status = 'processing';
        this.reply = '';
        this.error = null;

        if (!this.conversationId) {
            this.conversationId = crypto.randomUUID();
        }

        // Add user message to history
        this.history.push({ id: crypto.randomUUID(), role: 'user', content: query });

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const response = await fetch('/api/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    message: query,
                    history: this.history,
                    conversation_id: this.conversationId,
                    appointment_state: this.appointmentState
                })
            });

            let data;
            try {
                data = await response.json();
            } catch {
                throw new Error('The assistant returned an unreadable response.');
            }

            if (!response.ok || data.error) {
                // Surface the server's reason instead of a generic message.
                const error = new Error(data.error || `Request failed (${response.status}).`);
                error.code = data.code || `http_${response.status}`;
                throw error;
            }

            // Add AI response to history
            this.history.push({ id: crypto.randomUUID(), role: 'assistant', content: data.reply });

            // Update appointment state if provided
            if (data.appointment_state) {
                this.appointmentState = data.appointment_state;
            }

            this.reference = data.appointment?.reference || null;

            this.reply = data.reply;
            this.speak(this.reply);
            this.status = 'idle';
        } catch (e) {
            console.error('Processing error:', e);

            // Drop the failed turn so the next request does not resend it.
            this.history = this.history.filter((m) => m.content !== query || m.role !== 'user');

            this.status = 'error';
            this.error = e.message || 'Something went wrong.';
            this.reply = this.error;
            window.speechSynthesis?.cancel?.();
        }
    },

    speak(text) {
        window.speechSynthesis.cancel();
        this.status = 'speaking';
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.onend = () => {
            if (this.status === 'speaking') {
                this.status = 'idle';
            }
        };
        utterance.onerror = () => {
            if (this.status === 'speaking') {
                this.status = 'idle';
            }
        };
        window.speechSynthesis.speak(utterance);
    },

    reset() {
        window.speechSynthesis.cancel();
        this.stopListening();
        this.status = 'idle';
        this.transcript = '';
        this.reply = '';
        this.error = null;
        this.reference = null;
        this.textInput = '';
        this.history = [];
        this.conversationId = null;
        this.appointmentState = {
            appointment_intent: false,
            client_name: null,
            client_email: null,
            client_phone: null,
            service: null,
            preferred_date: null,
            preferred_time: null,
            requirements: null,
            confirmation_status: false
        };
    }
}));

Alpine.start();
