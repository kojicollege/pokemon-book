<x-home>
    <div class="container p-4 flex flex-wrap justify-center items-center gap-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold">
                No.
                {{ $pokemon['id'] }}
                {{ $pokemon['en_name'] }}
            </h1>
            <p class="text-lg">
                type:
                {{ isset($pokemon->type1) ? $pokemon->type1 : 'タイプ情報なし' }}
                @if($pokemon->type2) / {{ $pokemon->type2 }}@endif
            </p>
            <img src="{{ $pokemon['front_default'] }}" class="w-80 h-auto">
        </div>
        <div class="mt-5">
            <div class="text-base space-y-2">
                <p>Hp: <span class="font-bold">45</span></p>
                <p>Attack: <span class="font-bold">49</span></p>
                <p>Defense: <span class="font-bold">49</span></p>
                <p>Special Attack: <span class="font-bold">65</span></p>
                <p>Special Defense: <span class="font-bold">65</span></p>
                <p>Speed: <span class="font-bold">45</span></p>
                <p>Total Stats: <span class="font-bold">318</span></p>
            </div>
        </div>
    </div>
</x-home>