{{-- <belich::calendar
        id="tool-calendar" //this fields can be empty
        width="w-1/3" //this fields can be empty
    ></belich::calendar> --}}

{{-- Calendar --}}
<div id="{{ $id ?? 'calendar-' . ($key = \Illuminate\Support\Str::random(20)) }}" dusk="{{ $id ?? $key }}" class="{{ $width ?? 'w-1/3' }} p-4">
    <div class="flex-none text-center">
        <div class="block overflow-hidden shadow-md rounded-t">
            <div class="bg-blue-500 text-white text-xl py-2">
                {{ now()->englishMonth }}
            </div>
            <div class="pt-1">
                <span class="text-5xl font-bold leading-tight">
                    {{ now()->day }}
                </span>
            </div>
            <div class="text-center border-white py-2 mb-1">
                <span class="text-sm">
                    {{ now()->englishDayOfWeek }}
                </span>
            </div>
        </div>
    </div>
</div>

