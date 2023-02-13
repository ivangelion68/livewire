<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ArticleForm;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_new_articles(){

        Livewire::test('article-form')
            ->set('article.title', 'New Article')
            ->set('article.slug', 'new-article')
            ->set('article.content', 'Article Content')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('article.index'))
        ;
        $this->assertDatabaseHas('articles',[
            'title'=>'New Article',
            'content'=>'Article Content',
            'slug'=>'new-article'
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

    /** @test */
    public function blade_template_is_wired_properly(){
        Livewire::test('article-form')
            ->assertSeeHtml('wire:submit.prevent="save"')
            ->assertSeeHtml('wire:model="article.title"')
            ->assertSeeHtml('wire:model="article.content"')
            ->assertSeeHtml('wire:model="article.slug"');
    }

    /** @test */
    public function can_update_articles(){
        $article = Article::factory()->create();
        Livewire::test('article-edit', ['article'=>$article])
            ->assertSet('article.title',$article->title)
            ->assertSet('article.content',$article->content)
            ->assertSet('article.slug',$article->slug)
            ->set('article.title','Updated Title')
            ->set('article.content','Updated Content')
            ->set('article.slug','updated-slug')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('article.index'));
        $this->assertDatabaseCount('articles',1);
        $this->assertDatabaseHas('articles',
        [
            'title'=>'Updated Title',
            'slug'=>'updated-slug',
            'content'=>'Updated Content'
        ]);
    }

    /** @test  */
    public function null_slug_on_edit(){
        Livewire::test('article-edit')
            ->set('article.title','New Article')
            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.slug'=>'required']);
    }

    /** @test  */
    public function unique_slug_on_edit(){
        $article = Article::factory()->create();
        Livewire::test('article-edit')
            ->set('article.title','New Article')
            ->set('article.content','New content')
            ->set('article.slug',$article->slug)
            ->call('save')
            ->assertHasErrors(['article.slug'=>'unique:articles,slug'])
            ->assertSeeHtml(__('validation.unique',['attribute'=>'slug']));
    }

    /** @test  */
    public function unique_should_be_avoid_on_update(){
        $article = Article::factory()->create();
        Livewire::test('article-edit')
            ->set('article.title','New Article')
            ->set('article.content','New content')
            ->set('article.slug',$article->slug)
            ->call('save')
            ->assertHasErrors(['article.slug'=>'unique:articles,slug'])
            ->assertSeeHtml(__('validation.unique',['attribute'=>'slug']));
    }

    /** @test  */
    public function self_generate_slug_on_new(){
//        $article = Article::factory()->create();
        Livewire::test('article-form')
            ->set('article.title','New Article')
            ->assertSet('article.slug','new-article');
    }

    /** @test  */
    public function self_generate_slug_on_update(){
//        $article = Article::factory()->create();
        Livewire::test('article-edit')
            ->set('article.title','New Article')
            ->assertSet('article.slug','new-article');
    }

    /** @test  */
    public function slug_must_only_contain_letters_number_dashes_and_underscore(){
//        $article = Article::factory()->create();
        Livewire::test('article-form')
            ->set('article.title','New Article')
            ->set('article.slug','new-article*****')
            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.slug'=>'alpha_dash'])
            ->assertSeeHtml(__('validation.alpha_dash',['attribute'=>'slug']));
    }

}


