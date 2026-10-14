<x-layouts.app title="Start a Project - PengOffSec">
    <x-page-header
        eyebrow="Contact"
        title="Start your project."
        lede="Tell us about your requirements, and we'll help you determine the right next step for your security or software needs."
    />

    <div class="section">
        <div class="container-wide">
            <div class="grid lg:grid-cols-12 gap-12">

                <!-- Side info -->
                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-28 space-y-6">
                        <div class="card p-7">
                            <h2 class="font-bold text-ink-900">What happens next</h2>
                            <ol class="mt-5 space-y-5">
                                @foreach([
                                    'We review your requirements within one business day.',
                                    'A short call to understand your environment and objectives.',
                                    'A written scope and approach, with clear pricing.',
                                ] as $i => $step)
                                    <li class="flex gap-4">
                                        <span class="w-7 h-7 shrink-0 rounded-full bg-brand-50 border border-brand-100 text-brand-600 text-xs font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                                        <span class="text-sm text-ink-600 leading-relaxed pt-0.5">{{ $step }}</span>
                                    </li>
                                @endforeach
                            </ol>
                        </div>

                        <div class="card p-7">
                            <h2 class="font-bold text-ink-900">Prefer to talk first?</h2>
                            <p class="mt-3 text-sm text-ink-500 leading-relaxed">
                                Skip the form. Our AI assistant can answer service questions and book a consultation
                                directly.
                            </p>
                            <p class="mt-5 text-sm font-semibold text-ink-900">Use the assistant in the bottom-right corner</p>
                        </div>
                    </div>
                </aside>

                <!-- Form -->
                <div class="lg:col-span-8">
                    @if(session('success'))
                        <div class="alert-success mb-8">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="mb-8 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
                            <p class="font-semibold">Please review the highlighted fields.</p>
                        </div>
                    @endif

                    <form action="/contact" method="POST" class="card p-7 lg:p-10">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <div>
                                <label for="name" class="label-field">Full name <span class="text-brand-500">*</span></label>
                                <input type="text" id="name" name="name" placeholder="Jane Cooper" value="{{ old('name') }}" required class="input-field">
                                @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="label-field">Work email <span class="text-brand-500">*</span></label>
                                <input type="email" id="email" name="email" placeholder="jane@company.com" value="{{ old('email') }}" required class="input-field">
                                @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="company" class="label-field">Company name <span class="text-brand-500">*</span></label>
                                <input type="text" id="company" name="company" placeholder="Acme Industries" value="{{ old('company') }}" required class="input-field">
                                @error('company') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="project_type" class="label-field">Project type <span class="text-brand-500">*</span></label>
                                <input type="text" id="project_type" name="project_type" placeholder="Security assessment" value="{{ old('project_type') }}" required class="input-field">
                                @error('project_type') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="service_required" class="label-field">Service required <span class="text-brand-500">*</span></label>
                                <select id="service_required" name="service_required" required class="input-field">
                                    <option value="">Select a service</option>
                                    <optgroup label="Cybersecurity">
                                        <option value="OT/IT Security Services" @selected(old('service_required') === 'OT/IT Security Services')>OT/IT Security Services</option>
                                        <option value="Network Analysis" @selected(old('service_required') === 'Network Analysis')>Network Analysis</option>
                                        <option value="Penetration Testing" @selected(old('service_required') === 'Penetration Testing')>Penetration Testing</option>
                                        <option value="Security Assessment" @selected(old('service_required') === 'Security Assessment')>Security Assessment</option>
                                        <option value="Security Audit" @selected(old('service_required') === 'Security Audit')>Security Audit</option>
                                        <option value="OT Infrastructure Security Assessment" @selected(old('service_required') === 'OT Infrastructure Security Assessment')>OT Infrastructure Security Assessment</option>
                                        <option value="GRC (Governance, Risk & Compliance)" @selected(old('service_required') === 'GRC (Governance, Risk & Compliance)')>GRC (Governance, Risk &amp; Compliance)</option>
                                    </optgroup>
                                    <optgroup label="Software">
                                        <option value="Web Application Development" @selected(old('service_required') === 'Web Application Development')>Web Application Development</option>
                                        <option value="Mobile Application Development" @selected(old('service_required') === 'Mobile Application Development')>Mobile Application Development</option>
                                        <option value="Desktop Application Development" @selected(old('service_required') === 'Desktop Application Development')>Desktop Application Development</option>
                                    </optgroup>
                                </select>
                                @error('service_required') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="budget" class="label-field">Budget estimate <span class="text-brand-500">*</span></label>
                                <input type="text" id="budget" name="budget" placeholder="e.g. $15,000 â€“ $30,000" value="{{ old('budget') }}" required class="input-field">
                                @error('budget') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="timeline" class="label-field">Timeline / deadline <span class="text-brand-500">*</span></label>
                                <input type="text" id="timeline" name="timeline" placeholder="e.g. Within 6 weeks" value="{{ old('timeline') }}" required class="input-field">
                                @error('timeline') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="project_details" class="label-field">Project description <span class="text-brand-500">*</span></label>
                                <textarea id="project_details" name="project_details" rows="6" placeholder="Describe your environment, what you need assessed, and any constraints." required class="input-field resize-none">{{ old('project_details') }}</textarea>
                                @error('project_details') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-ink-100">
                            <p class="text-xs text-ink-600 max-w-sm">
                                We treat your details as confidential and never share them with third parties.
                            </p>
                            <button type="submit" class="btn-primary w-full sm:w-auto shrink-0">
                                Submit request
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
