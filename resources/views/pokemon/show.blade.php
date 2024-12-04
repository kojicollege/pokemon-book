<x-home>
    <div class="container p-4 flex flex-wrap justify-center items-center gap-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold md:text-3xl lg:text-4xl">
                No.
                {{ $pokemon['id'] }}
                {{ $pokemon['en_name'] }}
            </h1>
            <p class="text-lg">
                type:
                {{ isset($pokemon->type1) ? $pokemon->type1 : 'タイプ情報なし' }}
                @if($pokemon->type2) / {{ $pokemon->type2 }}@endif
            </p>
            <img src="{{ $pokemon['front_default'] }}"
                class="w-full h-auto border border-gray-300 rounded-lg shadow-md bg-white md:w-64 lg:w-80">
        </div>
        <div class="mt-5">
            <div class="text-base space-y-2">
                <p>HP: <span class="font-bold">{{ $pokemon['hp'] }}</span></p>
                <p>Attack: <span class="font-bold">{{ $pokemon['attack']}}</span></p>
                <p>Defense: <span class="font-bold">{{ $pokemon['defense']}}</span></p>
                <p>Special Attack: <span class="font-bold">{{ $pokemon['special_attack']}}</span></p>
                <p>Special Defense: <span class="font-bold">{{ $pokemon['special_defense']}}</span></p>
                <p>Speed: <span class="font-bold">{{ $pokemon['speed']}}</span></p>
                <p>Total Stats: <span class="font-bold">{{ $pokemon['total_stats']}}</span></p>
            </div>
        </div>
    </div>
</x-home>
