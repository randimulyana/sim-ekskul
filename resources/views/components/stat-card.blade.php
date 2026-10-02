@props(['label', 'value', 'icon' => null, 'trend' => null, 'variant' => 'default'])
@php
$colors = [
    'default' => 'text-slate-600',
    'primary' => 'text-blue-600',
    'success' => 'text-emerald-600',
    'warning' => 'text-amber-600',
    'danger' => 'text-red-600',
];
$bgColors = [
    'default' => 'bg-slate-100',
    'primary' => 'bg-blue-100',
    'success' => 'bg-emerald-100',
    'warning' => 'bg-amber-100',
    'danger' => 'bg-red-100',
];
$color = $colors[$variant] ?? $colors['default'];
$bg = $bgColors[$variant] ?? $bgColors['default'];
@endphp
<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-slate-200 p-6']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
            <p class="mt-1 text-3xl font-bold text-slate-900">{{ $value }}</p>
            @if($trend)
                <p class="mt-1 text-sm {{ $color }}">{{ $trend }}</p>
            @endif
        </div>
        @if($icon)
            <div class="flex-shrink-0 w-12 h-12 {{ $bg }} {{ $color }} rounded-xl flex items-center justify-center">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
