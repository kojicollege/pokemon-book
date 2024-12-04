<?php

namespace App\Http\Controllers;

use App\Models\Pokemons;

class PokemonController extends Controller
{
    public function index()
    {
        $pokemons = Pokemons::orderBy('id', 'asc')->get();

        return view('pokemon.index', compact('pokemons'));
    }

    public function show($id)
    {
        // 引数で受け取ったポケモンIDを使用してデータを取得
        $pokemon = Pokemons::find($id);

        // データが見つからない場合の処理
        if (! $pokemon) {
            return redirect()->route('poke_show')->with('error', 'ポケモンが見つかりません。');
        }

        return view('pokemon.show', compact('pokemon'));
    }
}
