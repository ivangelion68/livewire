<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Article;
class Articles extends Component
{
    public $search;

    public function mount(){
        $this->articles=Article::latest()->get();
    }

    public function render()
    {
        return view('livewire.articles')->layout('layouts.guest');
    }
}
