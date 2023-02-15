<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test  */
    public function articles_component_renders_properly()
    {
        $response = $this->get('/')->assertSeeLivewire('articles');

        $response->assertStatus(200);
    }
}
