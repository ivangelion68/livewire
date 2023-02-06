<div>
    <h1>Article List</h1>
    <a href="{{route('article.create')}}">Crear</a>
    <input type="search" name="search" id="search" wire:model.debounce.500ms='search' placeholder="Buscar">
    <ul>
        @foreach($articles as $article)
        <li>
            <a href="{{route('article.show', $article)}}">
                {{$article->title}}
            </a>
        </li>
        @endforeach
    </ul>
</div>
