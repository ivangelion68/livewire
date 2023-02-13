<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ArticleForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_new_articles(){
//        Livewire::test('article-form',[
//            'article.title'=>'New Article',
//            'article.content'=>'Article Content'
//        ])
//            ->call('save')
//            ->assertSessionHas('status')
//            ->assertRedirect(route('article.index'))
//        ;

        Livewire::test('article-form')
            ->set('article.title', 'New Article')
            ->set('article.content', 'Article Content')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('article.index'))
        ;
        $this->assertDatabaseHas('articles',[
            'title'=>'New Article',
            'content'=>'Article Content'
        ]);

    }

    /** @test */
    public function null_title(){
        Livewire::test('article-form')
//            ->set('article.title','New Article')
            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.title'=>'required']);
    }

    /** @test */
    public function title_with_less_characters(){
        Livewire::test('article-form')
            ->set('article.title','Ne')
            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.title'=>'min:4']);
    }

    /** @test */
    public function null_content(){
        Livewire::test('article-form')
            ->set('article.title','New Article')
//            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.content'=>'required']);
    }
}
