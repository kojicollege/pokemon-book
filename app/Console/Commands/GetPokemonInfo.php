<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiService;
use App\Models\Pokemons;
use ChrisKonnertz\DeepLy\DeepLy;

class GetPokemonInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getpokemoninfo {poke_id? : ポケモンID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ポケモンの情報を取得';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $poke_id = $this->argument('poke_id');
        $apiService = new ApiService();
        $Pokemons = new Pokemons();

        // 引数でポケモンのIDが指定されているかどうかで処理を分岐
        if (!empty($poke_id)) {
            $p_id = Pokemons::where('p_id', $poke_id)->first();
            if (!empty($p_id)) {
                // 処理を終了
                return;
            }

            // ポケモンIDが指定されている場合は特定のポケモンのみを取得
            $result = $apiService->fetchData($poke_id);
            $p_info = $this->getPokemonInfo($result);
            print_r($p_info['id']);
            print_r($p_info['jp_name']."\n");
            print_r($p_info['en_name']."\n");
            print_r("\n");
            $p_info = $Pokemons->createPokemon($p_info);
        } else {
            // 通常実行時
            // configに設定されている範囲で情報を取得
            $pokeid_min = config('pokemon.pokeid_range.min');
            $pokeid_max = config('pokemon.pokeid_range.max');
            for ($i = $pokeid_min; $i <= $pokeid_max; $i++) {
                $p_id = Pokemons::where('p_id', $i)->first();
                if (!empty($p_id)) {
                    // 次の処理移動
                    continue;
                }
                $result = $apiService->fetchData($i);
                $p_info = $this->getPokemonInfo($result);
                print_r($p_info['id']);
                print_r($p_info['jp_name']."\n");
                print_r($p_info['en_name']."\n");
                print_r("\n");
                $p_info = $Pokemons->createPokemon($p_info);
                sleep(1);
            }
        }
    }

    private function getPokemonInfo($data)
    {
        $p_info = [];
        // パラメータを設定
        $p_info['id'] = $data['id'];
        $p_info['en_name'] = $data['name'];

        // Googleだとクレジットカードの登録が必要だったのでDeepLに変更
        $apiKey = config('services.deeply.api_key');
        $deepLy = new DeepLy($apiKey);

        $p_info['jp_name'] = $deepLy->translate($p_info['en_name'], DeepLy::LANG_JA, DeepLy::LANG_AUTO);
        // $st = new GoogleTranslate($p_info['en_name'], $from, $to);
        // $p_info['jp_name'] = $st;
        $p_info['type1'] = $data['types'][0]['type']['name'];
        if (isset($data['types'][1])) {
            $p_info['type2'] = $data['types'][1]['type']['name'];
        } else {
            $p_info['type2'] = null;
        }
        $p_info['ability1'] = $data['abilities'][0]['ability']['name'];
        if (isset($data['abilities'][1]) && !$data['abilities'][1]['is_hidden']) {
            $p_info['ability2'] = $data['abilities'][1]['ability']['name'];
            $p_info['hidden_ability'] = $data['abilities'][2]['ability']['name'];
        } else {
            $p_info['ability2'] = null;
            if (isset($data['abilities'][1]['is_hidden'])) {
                $p_info['hidden_ability'] = $data['abilities'][1]['ability']['name'];
            } else {
                $p_info['hidden_ability'] = null;
            }
        }
        $p_info['hp'] = $data['stats'][0]['base_stat'];
        $p_info['attack'] = $data['stats'][1]['base_stat'];
        $p_info['defense'] = $data['stats'][2]['base_stat'];
        $p_info['special_attack'] = $data['stats'][3]['base_stat'];
        $p_info['special_defense'] = $data['stats'][4]['base_stat'];
        $p_info['speed'] = $data['stats'][5]['base_stat'];
        $p_info['total_stats'] = $p_info['hp'] + $p_info['attack'] + $p_info['defense'] + $p_info['special_attack'] + $p_info['special_defense'] + $p_info['speed'];
        $p_info['front_default'] = $data['sprites']['front_default'];
        $p_info['back_default'] = $data['sprites']['back_default'];
        if (isset($data['sprites']['other']['dream_world'])) {
            $p_info['dream_world_front_default'] = $data['sprites']['other']['dream_world']['front_default'];
        } else {
            $p_info['dream_world_front_default'] = null;
        }
        if (isset($data['sprites']['other']['home'])) {
            $p_info['home_front_default'] = $data['sprites']['other']['home']['front_default'];
        } else {
            $p_info['home_front_default'] = null;
        }
        if (isset($data['sprites']['other']['official-artwork'])) {
            $p_info['official_artwork_front_default'] = $data['sprites']['other']['official-artwork']['front_default'];
        } else {
            $p_info['official_artwork_front_default'] = null;
        }
        $p_info['height'] = $data['height'];
        $p_info['weight'] = $data['weight'];

        return $p_info;
    }
}
