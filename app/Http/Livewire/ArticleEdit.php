<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleEdit extends Component
{

    public Article $article;

    protected $rules=[
        'article.title'=>['required','min:4'],
        'article.content'=>['required'],
    ];

    public function mount(Article $article){
        $this->article= $article;
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.article-edit');
    }

    public function save(){
        $this->article->save();
        session()->flash('status',__('Article edited'));
        $this->redirectRoute('article.index');
    }
}
