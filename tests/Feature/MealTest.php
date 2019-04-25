<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFetchMeals()
    {
        $response = $this->get('/api/meals?lang=en');
        $response->assertJsonStructure(
            [
                'data',
                'links',
                'meta'
            ]
        );
        $response->assertStatus(200);
    }

    public function testFetchMeal() {
        $response = $this->get('/api/meals/1');
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title'
                ]
            ]
        );
        $response->assertStatus(200);
    }

    public function testWrongInput() {
        $response = $this->get('/api/meals/?lang=en&diff_time=abc');
        $response->assertStatus(422);
    }
}
