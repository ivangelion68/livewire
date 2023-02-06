<div>
    <h1>Editar Articulo</h1>
    <form wire:submit.prevent='save'>
        <label >
            Titulo
            <input type="text" name="title" id="title" wire:model='article.title'>
            @error('article.title')
            <div>{{$message}}</div>
            @enderror
        </label>
        <label>
            <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenido" wire:model='article.content'></textarea>
        </label>
        @error('article.content')
        <div>{{$message}}</div>
        @enderror
        <input type="submit" value="Guardar">
    </form>
</div>
