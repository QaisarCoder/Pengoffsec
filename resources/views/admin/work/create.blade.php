<x-layouts.admin title="Create Work - PengOffSec">
    <div class="max-w-2xl">
        <a href="{{ route('admin.work.index') }}" class="text-sm font-medium text-ink-500 hover:text-brand-600 transition">&larr; Back to work items</a>
        <h1 class="display-md mt-4">Create work item</h1>

        @if($errors->any())
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">Please review the highlighted fields.</div>
        @endif

        <form action="{{ route('admin.work.store') }}" method="POST" class="card p-7 mt-8 space-y-6">
            @csrf
            <div>
                <label for="title" class="label-field">Title <span class="text-brand-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="input-field">
                @error('title') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="label-field">Category <span class="text-brand-500">*</span></label>
                    <input type="text" id="category" name="category" value="{{ old('category') }}" required class="input-field">
                    @error('category') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="slug" class="label-field">Slug <span class="text-brand-500">*</span></label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required class="input-field">
                    @error('slug') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="description" class="label-field">Description <span class="text-brand-500">*</span></label>
                <textarea id="description" name="description" rows="6" required class="input-field resize-none">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Create</button>
                <a href="{{ route('admin.work.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
