<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ArticleForm;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_new_articles(){
        $user = User::factory()->create();
        Storage::fake('public');
        $image = UploadedFile::fake()->image('post-image.png')->size(2000);

        Livewire::actingAs($user)->test('article-form')
            ->set('image', $image)
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
            'slug'=>'new-article',
            'user_id'=>$user->id
        ]);
    }

    /** @test */
    public function image_must_be_2mb_max(){
        $user = User::factory()->create();
        Storage::fake('public');
        $image = UploadedFile::fake()->image('post-image.png')->size(3000);

        Livewire::actingAs($user)->test('article-form')
            ->set('image', $image)
            ->call('save')
            ->assertHasErrors(['image'=>'max'])
            ->assertSeeHtml(__('validation.max.file',['attribute'=>'image','max'=>'2048']))
        ;
    }

    /** @test */
    public function null_title(){
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-form')
//            ->set('article.title','New Article')
            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.title'=>'required']);
    }

    /** @test */
    public function title_with_less_characters(){
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-form')
            ->set('article.title','Ne')
            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.title'=>'min:4']);
    }

    /** @test */
    public function null_content(){
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-form')
            ->set('article.title','New Article')
//            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.content'=>'required']);
    }

    /** @test */
    public function blade_template_is_wired_properly(){
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-form')
            ->assertSeeHtml('wire:submit.prevent="save"')
            ->assertSeeHtml('wire:model="article.title"')
//            ->assertSeeHtml('wire:model="article.content"')
            ->assertSeeHtml('wire:model="article.slug"');
    }

    /** @test */
    public function can_update_articles(){
        $article = Article::factory()->create();
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-edit', ['article'=>$article])
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
        $user = User::factory()->create();
        $article = Article::factory()->create();
        Livewire::actingAs($user)->test('article-edit', ['article'=>$article])
            ->set('article.title','New Article')
            ->set('article.content','New content')
            ->set('article.slug','')
            ->call('save')
            ->assertHasErrors(['article.slug'=>'required']);
    }

    /** @test  */
    public function unique_slug_on_edit(){
        $article = Article::factory()->create();
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-edit')
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
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-edit')
            ->set('article.title','New Article')
            ->set('article.content','New content')
            ->set('article.slug',$article->slug)
            ->call('save')
            ->assertHasErrors(['article.slug'=>'unique:articles,slug'])
            ->assertSeeHtml(__('validation.unique',['attribute'=>'slug']));
    }

    /** @test  */
    public function self_generate_slug_on_new(){
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-form')
            ->set('article.title','New Article')
            ->assertSet('article.slug','new-article');
    }

    /** @test  */
    public function self_generate_slug_on_update(){
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-edit')
            ->set('article.title','New Article')
            ->assertSet('article.slug','new-article');
    }

    /** @test  */
    public function slug_must_only_contain_letters_number_dashes_and_underscore(){
        $user = User::factory()->create();
        Livewire::actingAs($user)->test('article-form')
            ->set('article.title','New Article')
            ->set('article.slug','new-article*****')
            ->set('article.content','New content')
            ->call('save')
            ->assertHasErrors(['article.slug'=>'alpha_dash'])
            ->assertSeeHtml(__('validation.alpha_dash',['attribute'=>'slug']));
    }

    /** @test  */
    public function guest_cannot_create_articles(){

//        $user = User::factory()->create();
        $this->get(route('article.create'))
            ->assertRedirect('login');

        $article = Article::factory()->create();
        $this->get(route('article.edit',$article))
            ->assertRedirect('login');
    }


}


