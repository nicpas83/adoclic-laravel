<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class ApiController extends Controller
{

    public function getEntitiesByCategory(Request $request, $category){

        $category = Category::where(['category' => $category])->first();

        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'La categoría solicitada no existe'
            ], 404);
        }

        $entities = $category->entities;

        $response = [
            'success' => true,
            'data' => $entities->map(function($entity){
                return [
                    'api' => $entity->api,
                    'description' => $entity->description,
                    'link' => $entity->link,
                    'category' => [
                        'id' => $entity->category_id,
                        'category' => $entity->category->category
                    ]
                ];
            })
        ];

        return response()->json($response);

    }



}
