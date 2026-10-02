@props(['icon' => null, 'title' => 'Tidak ada data', 'description' => null, 'action' => null, 'actionUrl' => null])
<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-16 text-center']) }}>
    @if($icon)
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
            {!! $icon !!}
        </div>
    @else
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
    @endif
    <h3 class="text-base font-semibold text-slate-900 mb-1">{{ $title }}</h3>
    @if($description)
        <p class="text-sm text-slate-500 max-w-sm">{{ $description }}</p>
    @endif
    @if($action && $actionUrl)
        <a href="{{ $actionUrl }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">{{ $action }}</a>
    @endif
    {{ $slot }}
</div>
