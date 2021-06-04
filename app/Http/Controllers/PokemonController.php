<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PokemonController extends Controller
{
    protected $pokemonService;
    CONST itemsPerPage = 15;
    CONST timeforCache = 300;
    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
        $this->homeView = 'home';
        $this->maxItemsToRetrieve = env('MAX_ITEMS_RETRIEVE');
    }

    public function pokemonDetailByPage($page)
    {
        $cacheKey = 'pokemonPage_'.$page;
        if(Cache::has($cacheKey)){
            $data = Cache::get($cacheKey);
            return $this->paginate($data, self::itemsPerPage, $page);
        }
        $pokeData = $this->pokemonService->getPokemonsDetailsByPage($page, self::itemsPerPage);
        Cache::put($cacheKey, $pokeData, self::timeforCache);
        return $this->paginate($pokeData, self::itemsPerPage, $page);
    }
    
    public function paginate($rows, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $rows instanceof Collection ? $rows : Collection::make($rows);
        return  new LengthAwarePaginator($items, $this->maxItemsToRetrieve, $perPage, $page, $options);
    }
    
}
