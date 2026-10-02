@props(['label' => null, 'name' => '', 'error' => null, 'hint' => null])
<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 ' . ($error ? 'border-red-400 focus:border-red-500 focus:ring-red-500' : '')]) }}
    />
    @if($hint && !$error)
        <p class="text-xs text-slate-500">{{ $hint }}</p>
    @endif
    @if($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @endif
</div>
