@props(['name', 'items' => null])

@php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Cache;
    
    // If items are not passed, fetch the root items for the menu by name with caching
    if (!$items) {
        $cacheKey = "menu_{$name}_items";
        $cacheDuration = 3600; // 1 hour cache
        
        try {
            $items = Cache::remember($cacheKey, $cacheDuration, function () use ($name) {
                $menu = Menu::where('name', $name)
                    ->with([
                        'items' => function ($query) {
                            $query->whereNull('parent_id')->orderBy('order');
                        },
                        'items.children',
                    ])
                    ->first();
                
                return $menu ? $menu->items : collect();
            });
        } catch (\Exception $e) {
            // Fallback to direct database query if cache fails
            $menu = Menu::where('name', $name)
                ->with([
                    'items' => function ($query) {
                        $query->whereNull('parent_id')->orderBy('order');
                    },
                    'items.children',
                ])
                ->first();
            
            $items = $menu ? $menu->items : collect();
        }
    }
@endphp

@if ($items && $items->count())
    <ul class="mt-4">
        @foreach ($items as $item)
            <li class="mb-2">
                <a class="footer-link" href="{{ $item->url }}" @if ($item->target) target="{{ $item->target }}" @endif>
                    @if ($item->icon_class)
                        <i class="{{ $item->icon_class }}"></i>
                    @endif
                    {{ $item->title }}
                </a>
                @if ($item->children && $item->children->count())
                    <x-menu :items="$item->children" />
                @endif
            </li>
        @endforeach
    </ul>
@endif

<style>
    .footer-link:hover {
        color: #ffffff !important;
    }
</style>
