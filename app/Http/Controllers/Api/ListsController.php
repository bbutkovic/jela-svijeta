<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tag;
use App\Ingredient;
use App\Category;
use App\Language;

use App\Http\Resources\TagCollection;
use App\Http\Resources\IngredientCollection;
use App\Http\Resources\CategoryCollection;

class ListsController extends Controller
{
    public function tags(Language $lang)
    {
        $tags = Tag::with('translations')->get();
        return (new TagCollection($tags))->setLanguage($lang);
    }

    public function ingredients(Language $lang)
    {
        $ingredients = Ingredient::all();
        return (new IngredientCollection($ingredients))->setLanguage($lang);
    }

    public function categories(Language $lang)
    {
        $categories = Category::all();
        return (new CategoryCollection($categories))->setLanguage($lang);
    }

    public function languages() {
        return response()->json([
            'data' => Language::select('id', 'code', 'name')->get()
        ]);
    }
}
