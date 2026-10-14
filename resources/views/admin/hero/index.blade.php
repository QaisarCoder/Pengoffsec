<x-layouts.admin title="Edit Homepage Hero - PengOffSec">
    <div class="max-w-2xl">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-ink-500 hover:text-brand-600 transition">&larr; Back to dashboard</a>
        <h1 class="display-md mt-4">Edit homepage hero</h1>
        <p class="mt-2 text-sm text-ink-500">This content appears at the top of your homepage.</p>

        @if(session('success'))
            <div class="alert-success mt-6">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">Please review the highlighted fields.</div>
        @endif

        <form action="{{ route('admin.hero.update') }}" method="POST" class="card p-7 mt-8 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="headline" class="label-field">Headline <span class="text-brand-500">*</span></label>
                <input type="text" id="headline" name="headline" value="{{ old('headline', $hero->headline) }}" required class="input-field">
                @error('headline') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="subheadline" class="label-field">Subheadline <span class="text-brand-500">*</span></label>
                <textarea id="subheadline" name="subheadline" rows="5" required class="input-field resize-none">{{ old('subheadline', $hero->subheadline) }}</textarea>
                @error('subheadline') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label for="cta_text" class="label-field">CTA text <span class="text-brand-500">*</span></label>
                    <input type="text" id="cta_text" name="cta_text" value="{{ old('cta_text', $hero->cta_text) }}" required class="input-field">
                    @error('cta_text') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="cta_link" class="label-field">CTA link <span class="text-brand-500">*</span></label>
                    <input type="text" id="cta_link" name="cta_link" value="{{ old('cta_link', $hero->cta_link) }}" required class="input-field">
                    @error('cta_link') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Save hero</button>
                <a href="/" target="_blank" rel="noopener" class="btn-secondary">Preview homepage</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
