<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Article;
use Livewire\WithFileUploads;

class ArticleForm extends Component
{
    use WithFileUploads;
    public Article $article;

    public $image;
    protected $rules=[
        'article.title'=>['required','min:4'],
        'article.content'=>['required'],
        'article.slug'=>['required','unique:articles,slug','alpha_dash'],
        'image'=>['image', 'max:2048']
    ];



    public function mount(Article $article){
        $this->article = $article;
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function updatedArticleTitle($title){
        $this->article->slug = Str::slug($title);
    }

    public function save(){
        $this->validate();
        $this->article->image = $this->image->store('/','public');
        Auth::user()->articles()->save($this->article);
        session()->flash('status',__('Article created'));
        $this->redirectRoute('article.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
