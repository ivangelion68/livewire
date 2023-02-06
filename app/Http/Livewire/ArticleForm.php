<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Article;
class ArticleForm extends Component
{
    public $title;
    public $content;

    protected $rules=[
        'title'=>['required','min:4'],
        'content'=>['required'],
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.article-form');
    }

    public function save(){
        Article::create($this->validate());
        session()->flash('status',__('Article created'));
        $this->redirectRoute('article.index');

    }
}
