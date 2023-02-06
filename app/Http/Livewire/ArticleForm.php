<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Article;
class ArticleForm extends Component
{
    public $title;
    public $contenido;
    public function render()
    {
        return view('livewire.article-form');
    }

    public function save(){
        $article = new Article();
        $article->title=$this->title;
        $article->content=$this->contenido;
        $article->save();
        session()->flash('status',__('Article created'));
        $this->redirectRoute('article.index');

    }
}
