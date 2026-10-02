@props(['padding' => 'p-6', 'class' => ''])
<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-slate-200 ' . $padding]) }}>
    {{ $slot }}
</div>
