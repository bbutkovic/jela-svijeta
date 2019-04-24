<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

use App\Tag;
use App\Ingredient;
use App\Meal;
use App\Category;

class DatabaseSeeder extends Seeder
{
    private $faker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $this->faker = $faker;

        //Create our 2 langauges we'll use in testing
        $languages = collect([
            [
                'code' => 'en',
                'name' => 'English'
            ],
            [
                'code' => 'hr',
                'name' => 'Croatian'
            ]
        ]);
        $this->createLanguages($languages);
        

        //Create 3 main categories we'll use in testing
        $categoryNames = collect([
            [
                'hr' => 'Juhe',
                'en' => 'Soups',
            ],
            [
                'hr' => 'Kolači',
                'en' => 'Cakes',
            ],
            [
                'hr' => 'Hamburgeri',
                'en' => 'Burgers'
            ]
        ]);
        $this->createCategories($categoryNames);

        //Create tags and ingredients
        factory(Tag::class, $faker->numberBetween(20, 25))->create();
        factory(Ingredient::class, $faker->numberBetween(20, 25))->create();

        //Create meals with random (or none) categories attached
        $categories = Category::all();
        $this->createMeals($categories, $faker->numberBetween(15, 20));
    
        $meals = Meal::all();
        $tags = Tag::pluck('id');
        $ingredients = Ingredient::pluck('id');

        $this->attachTagsToMeals($meals, $tags);
        $this->attachIngredientsToMeals($meals, $ingredients);
    }

    //Go through every language we wanted to insert but check if it already exists in DB. If not, create it.
    private function createLanguages($languages) {
        $existing = DB::table('languages')->select('code')->get();
        $toInsert = $languages->filter(function($lang) use($existing) {
            return !$existing->contains('code', $lang['code']);
        });
        DB::table('languages')->insert($toInsert->toArray());
    }

    private function createCategories($categories) {
        $categories = $categories->map(function($category) {
            $titles = collect($category)->flatMap(function ($name, $locale) {
                return ['title:' . $locale => $name];
            });
            
            $lastLocale = $titles[$titles->keys()->last()];
            $slug = 'category-' . strtolower($lastLocale);

            return $titles->merge([
                'slug' => $slug
            ]);
        });

        foreach($categories as $category) {
            App\Category::create($category->toArray());
        }
    }

    private function createMeals($categories, $amount = 10) {
        for($i = 0; $i < $amount; $i++) {
            $category = $this->faker->boolean() ? $this->faker->randomElement($categories) : null;
            factory(Meal::class)->create([
                'category_id' => $category ? $category->id : null
            ]);
        }
    }

    private function attachTagsToMeals($meals, $tags) {
        foreach($meals as $meal) {
            $amount = $this->faker->numberBetween(1, 7);
            $meal->tags()->sync($tags->random($amount));
            $meal->save();
        }
    }

    private function attachIngredientsToMeals($meals, $ingredients) {
        foreach($meals as $meal) {
            $amount = $this->faker->numberBetween(1, 7);
            $meal->ingredients()->sync($ingredients->random($amount));
            $meal->save();
        }
    }
}
