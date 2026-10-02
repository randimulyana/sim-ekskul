@props(['label' => null, 'name' => '', 'error' => null, 'rows' => 4])
<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none ' . ($error ? 'border-red-400' : '')]) }}
    >{{ $slot }}</textarea>
    @if($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @endif
</div>
