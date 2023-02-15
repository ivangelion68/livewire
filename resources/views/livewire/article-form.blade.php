<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('New Article')}}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-jet-form-section submit="save">
                <x-slot name="title">{{__('New Article')}}</x-slot>
                <x-slot name="description">{{__('Some description')}}</x-slot>
                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="title" :value="__('Title')" />
                        <x-jet-input type="text" name="title" id="title" class="mt-1 block w-full" wire:model="article.title"></x-jet-input>
                        <x-jet-input-error for="article.title" class="mt-2"></x-jet-input-error>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="slug" :value="__('Slug')" />
                        <x-jet-input type="text" name="slug" id="slug" class="mt-1 block w-full" wire:model="article.slug"></x-jet-input>
                        <x-jet-input-error for="article.slug" class="mt-2"></x-jet-input-error>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="content" :value="__('Content')" />
                        <x-textarea name="content" id="content" class="mt-1 block w-full" wire:model="article.content"></x-textarea>
                        <x-jet-input-error for="article.content" class="mt-2"></x-jet-input-error>
                    </div>
                    <x-slot name="actions">
{{--                        <input type="submit" value="Guardar">--}}
                        <x-jet-button>{{__('Save')}}</x-jet-button>
                    </x-slot>
                </x-slot>
            </x-jet-form-section>
        </div>
    </div>
</div>
