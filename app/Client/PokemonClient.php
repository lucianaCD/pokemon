<?php

Namespace App\Client;

class PokemonClient {
    protected $pokeApi;
    
    public function __construct() {
        $this->pokeApi = env('POKEMON_API_URL');
        $this->client = new \GuzzleHttp\Client();
    }
    
    public function getPokemons(){
        $response = $this->client->get($this->pokeApi);
        return json_decode($response->getBody(), true);
    }
    public function getPokemonDetails($number){
        $response = $this->client->get($this->pokeApi.'/'.$number);
        return json_decode($response->getBody(), true);
    }
}
