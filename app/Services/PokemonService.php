<?php
Namespace App\Services;

Use App\Client\PokemonClient;
use Illuminate\Support\Facades\Log;

class PokemonService 
{
    protected $pokemonClient;

    public function __construct(PokemonClient $pokemonClient) 
    {
        $this->pokemonClient = $pokemonClient;
    }
    
    /**
     * Gets pokemon details for indicated page acording to items quantity per page
     * @param int $page
     * @param int $itemsPerPage
     * @return array
     */
    public function getPokemonsDetailsByPage($page, $itemsPerPage)
    {
        $limitPageVal = $this->getValuesForPagination($page, $itemsPerPage);
        return $this->getPokemonDetails($limitPageVal);
    }
    
    /**
     * Get pokemon details trough data retrieved from api
     * @param array $limits
     * @return array
     */
    public function getPokemonDetails($limits)
    {
        $pokeData  = [];
        try {
            $init = $limits['init'];
            $end = $limits['end'];
            for ($i = $init; $i < $end+1; $i++){
                $pokemonData = $this->pokemonClient->getPokemonDetails($i);
                $pokeData[] = $this->formatPokemonData($pokemonData);
            }
            return $pokeData;            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Format pokemon data from data received from api
     * @param type $rawData
     * @return type
     */    
    private function formatPokemonData($rawData)
    {
        $formatedData = [
            'id' => $rawData['id'],
            'name' => $rawData['name'],
            'number' => $rawData['id'],
            'types' => $this->formatPokemonTypes($rawData['types']),
            'photo' => $rawData['sprites']['other']['dream_world']['front_default'],
            'height' => $rawData['height'],
            'weight' => $rawData['weight'],
            'experience' => $rawData['base_experience']
        ];
        return $formatedData;
        
    }
    /**
     * Format pokemon type as string
     * @param array $rawTypes
     * @return string
     */
    private function formatPokemonTypes($rawTypes)
    {
        $allTypes = [];
        foreach ($rawTypes as $types){
            $allTypes[] =  $types['type']['name'];
        }
        return implode(' - ', $allTypes);
    }
    /**
     * Get initial and ending values for pagination
     * @param int $page
     * @param int $itemsPerPage
     * @return array
     */
    private function getValuesForPagination($page, $itemsPerPage)
    {
        if($page == 1){
            return ['init' => 1, 'end' => $itemsPerPage];
        }
        $init = ($page*$itemsPerPage)-($itemsPerPage-1);
        $end = $page*$itemsPerPage;
        return ['init' => $init, 'end' => $end];
    }
}
