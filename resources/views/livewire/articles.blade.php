<div>
    <h1>Article List</h1>
    <input type="search" name="search" id="search" wire:model.debounce.500ms='search' placeholder="Buscar">
    <ul>
        @foreach($articles as $article)
        <li>{{$article->title}}</li>
        @endforeach
    </ul>
</div>
