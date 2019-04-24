<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Create our target
        $languages = [
            'en' => 'English',
            'hr' => 'Croatian',
        ];
        $existing = DB::table('languages')->select('code')->get();
        $toInsert = [];
        foreach($languages as $code => $name) {
            if(!$existing->contains('code', $code)) {
                $toInsert[] = [
                    'code' => $code,
                    'name' => $name,
                ];
            }
        }
        DB::table('languages')->insert($toInsert);

        //Create meals
        factory(App\Meal::class, 15)->create();
    }
}
