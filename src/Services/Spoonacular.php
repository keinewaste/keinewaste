<?php
namespace KeineWaste\Services;

use Unirest\Request;

class Spoonacular {

    /** @var  string[] $headers */
    protected $headers;

    /** @var  string $baseUrl */
    protected $baseUrl;

    /** @var  string $baseUrlRecipeImage */
    protected $baseUrlRecipeImage;

    /** @var  string $baseUrlIngredientImage */
    protected $baseUrlIngredientImage;

    function __construct($baseUrl, $headers, $baseUrlRecipeImage, $baseUrlIngredientImage)
    {
        $this->headers = $headers;
        $this->baseUrl = $baseUrl;
        $this->baseUrlRecipeImage = $baseUrlRecipeImage;
        $this->baseUrlIngredientImage = $baseUrlIngredientImage;
    }

    public function autocomplete($query)
    {
        $result = [];

        // try ingredients
        $response = Request::get($this->baseUrl . "/food/ingredients/autocomplete?query=" . $query, $this->headers);

        if (count($response->body)) {
            foreach ($response->body as $ingredient) {
                $result[] = [
                    'title' => $ingredient->name,
                    'imageUrl' => $this->baseUrlIngredientImage . $ingredient->image,
                ];
            }
            return $result;
        }

        // @todo: move this logic to controller

        // try recipes
        $response = Request::get($this->baseUrl . "/recipes/search?query=" . $query, $this->headers);

        if (count($response->body)) {
            foreach ($response->body->results as $recipe) {
                $result[] = [
                    'title' => $recipe->title,
                    'imageUrl' => $this->baseUrlRecipeImage . $recipe->image,
                ];
            }
            return $result;
        }
    }
}