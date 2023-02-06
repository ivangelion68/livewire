<div>
    <h1>Titulo: {{$article->title}}</h1>
    <p>
        {{$article->content}}
    </p>
    <a href="{{route('article.index')}}">Volver al indice</a>
</div>
