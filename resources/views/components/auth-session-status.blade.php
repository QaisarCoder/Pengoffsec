@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 font-medium text-sm text-emerald-800']) }}>
        {{ $status }}
    </div>
@endif
