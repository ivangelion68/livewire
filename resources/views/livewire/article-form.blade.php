<div>
    <h1>Crear Articulo</h1>
    <form wire:submit.prevent='save'>
        <label >
            Titulo
            <input type="text" name="titulo" id="titulo" wire:model='title'>
        </label>
        <label>
            <textarea name="contenido" id="contenido" cols="30" rows="10" placeholder="Contenido" wire:model='contenido'></textarea>
        </label>
        <input type="submit" value="Guardar">
    </form>
</div>
