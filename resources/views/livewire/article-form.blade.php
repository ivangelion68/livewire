<div>
    <h1>Crear Articulo</h1>
    <form wire:submit.prevent='save'>
        <label >
            Titulo
            <input type="text" name="title" id="title" wire:model='title'>
            @error('title')
                <div>{{$message}}</div>
            @enderror
        </label>
        <label>
            <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenido" wire:model='content'></textarea>
        </label>
        @error('content')
                <div>{{$message}}</div>
            @enderror
        <input type="submit" value="Guardar">
    </form>
</div>
