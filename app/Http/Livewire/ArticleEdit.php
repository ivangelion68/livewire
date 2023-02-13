<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ArticleEdit extends Component
{

    public Article $article;

    protected function rules(){

         return[
             'article.title'=>['required', 'min:4'],
             'article.content'=>['required'],
             'article.slug'=>[
                   'required'
                 , Rule::unique('articles','slug')->ignore($this->article)
                 ]
        ];
    }

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
        $this->validate();
        $this->article->save();
        session()->flash('status',__('Article edited'));
        $this->redirectRoute('article.index');
    }
}
