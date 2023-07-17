<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Models\Entity;
use App\Models\Category;

class EntityService{

    public function saveEntitiesFromApi(){

        $response = Http::get('https://api.publicapis.org/entries');
        $data = $response->json();

        $entries = $data['entries'];
        $categories = Category::pluck('id', 'category');

        foreach($entries as $entry){
            if($entry['Category'] === 'Animals' || $entry['Category'] === 'Security'){

                $entity = new Entity();
                $entity->api = $entry['API'];
                $entity->description = $entry['Description'];
                $entity->link = $entry['Link'];
                $entity->category_id = $categories[$entry['Category']];

                $entity->save();
            }
        }
    }


}
