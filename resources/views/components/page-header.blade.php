@props(['title', 'description' => null, 'breadcrumbs' => []])
<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    @if(count($breadcrumbs) > 0)
        <nav class="flex items-center gap-1 text-sm text-slate-500 mb-2">
            @foreach($breadcrumbs as $i => $crumb)
                @if($i > 0)
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                @endif
                @if(isset($crumb['url']))
                    <a href="{{ $crumb['url'] }}" class="hover:text-slate-700">{{ $crumb['label'] }}</a>
                @else
                    <span class="text-slate-700 font-medium">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
    @endif
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $title }}</h1>
            @if($description)
                <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
            @endif
        </div>
        @if(isset($actions))
            <div class="flex items-center gap-2 flex-shrink-0">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
