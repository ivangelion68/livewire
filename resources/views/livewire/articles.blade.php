<div>
    <h1>Article List</h1>
    <ul>
        @foreach($articles as $article)
        <li>{{$article->title}}</li>
        @endforeach
    </ul>
</div>
