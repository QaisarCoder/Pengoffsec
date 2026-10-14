<x-layouts.admin title="Create Service - PengOffSec">
    <div class="max-w-2xl">
        <a href="{{ route('admin.services.index') }}" class="text-sm font-medium text-ink-500 hover:text-brand-600 transition">&larr; Back to services</a>
        <h1 class="display-md mt-4">Create service</h1>

        @if($errors->any())
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">Please review the highlighted fields.</div>
        @endif

        <form action="{{ route('admin.services.store') }}" method="POST" class="card p-7 mt-8 space-y-6">
            @csrf
            <div>
                <label for="name" class="label-field">Name <span class="text-brand-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="input-field">
                @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="description" class="label-field">Description <span class="text-brand-500">*</span></label>
                <textarea id="description" name="description" rows="5" required class="input-field resize-none">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="category" class="label-field">Category <span class="text-brand-500">*</span></label>
                <select id="category" name="category" required class="input-field">
                    <option value="Cybersecurity" @selected(old('category') === 'Cybersecurity')>Cybersecurity</option>
                    <option value="Software" @selected(old('category') === 'Software')>Software</option>
                </select>
                @error('category') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Save service</button>
                <a href="{{ route('admin.services.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
