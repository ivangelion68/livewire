<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Article;
class Articles extends Component
{
    public $articles;

    public function mount(){
        $this->articles=Article::all();
    }

    public function render()
    {
        return view('livewire.articles');
    }
}
