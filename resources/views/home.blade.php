<x-layouts.app title="PengOffSec - Cybersecurity & Engineering">
    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-32 pb-12 md:pt-40 md:pb-16 lg:pt-44 lg:pb-20">
        <div class="absolute inset-0 security-grid security-grid-mask pointer-events-none" aria-hidden="true"></div>
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[900px] h-[600px] glow-coral hero-glow pointer-events-none" aria-hidden="true"></div>

        <div class="container-wide relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 lg:gap-10 items-center">
                <div class="lg:col-span-6 animate-fade-up">
                    <span class="badge">
                        <span class="badge-dot"></span>
                        Security assessments available
                    </span>

                    <h1 class="display-xl mt-7 text-balance">
                        {{ $hero->headline ?? 'Secure. Build. Scale.' }}
                    </h1>

                    <p class="lede mt-7 max-w-xl">
                        {{ $hero->subheadline ?? 'PengOffSec builds secure digital products and helps businesses protect the technology they depend on.' }}
                    </p>

                    <div class="mt-9 flex flex-wrap items-center gap-4">
                        <a href="{{ $hero->cta_link ?? '/contact' }}" class="btn-primary">
                            {{ $hero->cta_text ?? 'Request an assessment' }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
                            </svg>
                        </a>
                        <a href="/process" class="btn-secondary">See how we work</a>
                    </div>

                    <!-- Trust row -->
                    <dl class="mt-14 grid grid-cols-3 gap-6 max-w-lg">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-ink-600">Engagements</dt>
                            <dd class="mt-1.5 text-2xl font-bold tracking-tight text-ink-900">120+</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-ink-600">Critical findings</dt>
                            <dd class="mt-1.5 text-2xl font-bold tracking-tight text-ink-900">Zero</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-ink-600">Response</dt>
                            <dd class="mt-1.5 text-2xl font-bold tracking-tight text-ink-900">24h</dd>
                        </div>
                    </dl>
                </div>

                <!-- Technical visual panel -->
                <div class="lg:col-span-6">
                    <div class="relative rounded-2xl border border-ink-200 bg-white/80 backdrop-blur-sm shadow-card-hover overflow-hidden">
                        <div class="flex items-center justify-between px-5 py-3.5 border-b border-ink-100 bg-white">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-ink-200"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-ink-200"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-ink-200"></span>
                            </div>
                            <span class="font-mono text-[11px] uppercase tracking-widest text-ink-600">Attack surface — sample</span>
                        </div>
                        <div class="relative h-[280px] sm:h-[340px] lg:h-[380px] dot-grid bg-ink-50/50">
                            <div id="hero-canvas" class="w-full h-full"></div>
                            <div class="absolute bottom-4 left-4 flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-ink-200 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse-soft"></span>
                                <span class="font-mono text-[11px] text-ink-600">scanning · 0 critical</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="pt-16 pb-12 md:pt-20 md:pb-14 lg:pt-24 lg:pb-16">
        <div class="container-wide">
            <div class="max-w-2xl">
                <span class="eyebrow">Capabilities</span>
                <h2 class="display-lg mt-4 text-balance">What we do</h2>
                <p class="lede mt-5">Security and software capabilities built around your real environment.</p>
            </div>

            @foreach(['Cybersecurity', 'Software'] as $category)
                <div class="mt-14 md:mt-16">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.14em] text-ink-600">{{ $category }}</h3>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($service->where('category', $category) as $s)
                            <a href="/contact" class="group card-interactive p-7 flex flex-col">
                                <div class="icon-chip mb-6" aria-hidden="true">
                                    @if($s->category === 'Cybersecurity')
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                    @endif
                                </div>
                                <h4 class="text-lg font-bold text-ink-900 group-hover:text-brand-600 transition-colors">{{ $s->name }}</h4>
                                <p class="mt-3 text-sm text-ink-500 leading-relaxed flex-grow line-clamp-3">{{ $s->description }}</p>
                                <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 transition group-hover:gap-2.5">
                                    Get started
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
                                    </svg>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Case Studies Section -->
    <section class="section-muted pt-12 pb-16 md:pt-14 md:pb-20 lg:pt-16 lg:pb-24">
        <div class="container-wide">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div class="max-w-2xl">
                    <span class="eyebrow">Selected work</span>
                    <h2 class="display-lg mt-4">Our work</h2>
                </div>
                <a href="/work" class="btn-secondary btn-sm shrink-0 self-start md:self-auto">
                    View all case studies
                    @if($case->isNotEmpty())
                        <span class="text-ink-600">({{ $case->count() }})</span>
                    @endif
                </a>
            </div>

            <x-case-study-index :studies="$case" />
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section">
        <div class="container-wide">
            <div class="relative overflow-hidden rounded-3xl bg-ink-900 px-8 py-16 lg:px-16 lg:py-20 text-center">
                <div class="absolute inset-0 dot-grid opacity-[0.08] pointer-events-none" aria-hidden="true"></div>
                <div class="absolute -bottom-24 left-1/2 -translate-x-1/2 w-[600px] h-[300px] glow-coral opacity-70 pointer-events-none" aria-hidden="true"></div>

                <div class="relative max-w-2xl mx-auto">
                    <h2 class="display-md text-white text-balance">Not sure what you actually need?</h2>
                    <p class="mt-5 text-lg text-ink-300 leading-relaxed">
                        Start with a conversation. We will help define the right scope and assessment approach for your environment.
                    </p>
                    <div class="mt-9 flex flex-wrap items-center justify-center gap-4">
                        <a href="/contact" class="btn-primary">Request an assessment</a>
                        <a href="/process" class="btn px-6 py-3 text-white border border-white/20 hover:bg-white/10">How we work</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="module">
        const canvas = document.getElementById('hero-canvas');
        if (canvas) {
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, canvas.clientWidth / canvas.clientHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.setSize(canvas.clientWidth, canvas.clientHeight);
            canvas.appendChild(renderer.domElement);

            const group = new THREE.Group();
            for (let i = 0; i < 50; i++) {
                const geometry = new THREE.SphereGeometry(0.05);
                const material = new THREE.MeshBasicMaterial({ color: 0xf4572d });
                const mesh = new THREE.Mesh(geometry, material);
                mesh.position.set(Math.random() * 4 - 2, Math.random() * 4 - 2, Math.random() * 4 - 2);
                group.add(mesh);
            }
            scene.add(group);
            camera.position.z = 5;

            function animate() {
                requestAnimationFrame(animate);
                group.rotation.y += 0.002;
                renderer.render(scene, camera);
            }
            animate();
        }
    </script>
</x-layouts.app>
