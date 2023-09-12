@php
    $heading = $this->getHeading();
    $filters = $this->getFilters();
@endphp

<x-filament-widgets::widget class="filament-google-maps-widget">
    <x-filament::section>
        @if ($heading || $filters)
            <div class="flex items-center justify-between gap-8">
                @if ($heading)
                    <h3 class="text-base font-semibold leading-6">
                        {{ $heading }}
                    </h3>
                @endif

                @if ($filters)
                    <select
                        wire:model="filter"
                        @class([
                            'focus:border-primary-500 focus:ring-primary-500 block h-10 rounded-lg border-gray-300 text-gray-900 shadow-sm transition duration-75 focus:ring-1 focus:ring-inset',
                            'dark:focus:border-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200' => config('filament.dark_mode'),
                        ])
                        wire:loading.class="animate-pulse"
                    >
                        @foreach ($filters as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endif

        <div
            class=""
            wire:key="{{ rand() }}"
            x-ignore
            ax-load
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-google-maps-widget', 'cheesegrits/filament-google-maps') }}"
            x-data="filamentGoogleMapsWidget({
                    cachedData: {{  json_encode($this->getCachedData()) }},
                    config: {{ $this->getMapConfig()}},
                    mapEl: $refs.map,
{{--                    mapFilterIds: {{ $this->mapIsFilter() ? 'wire:@entangle("mapFilterIds")' : null}}--}}
                })"
            wire:ignore
            @if ($maxHeight = $this->getMaxHeight())
                style=" max-height: {{ $maxHeight }}"
            @endif
        >
            <div
                @if ($this->mapIsFilter())
                    wire: @entangle('mapFilterIds')
                @endif
                wire:ignore
                id="map-{{ $this->getMapId() }}"
                x-ref="map"
                class="w-full"
                style="min-height: 50vh; z-index: 1 !important"
            ></div>
        </div>
    </x-filament::section>

    <x-filament::section class="mt-2">
        {{ $this->table }}
    </x-filament::section>
</x-filament-widgets::widget>
