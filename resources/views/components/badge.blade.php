@props(['variant' => 'default'])
@php
$variants = [
    'default' => 'bg-slate-100 text-slate-700',
    'primary' => 'bg-blue-100 text-blue-700',
    'success' => 'bg-emerald-100 text-emerald-700',
    'warning' => 'bg-amber-100 text-amber-700',
    'danger' => 'bg-red-100 text-red-700',
    'info' => 'bg-blue-50 text-blue-600',
];
$class = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . ($variants[$variant] ?? $variants['default']);
@endphp
<span {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</span>
