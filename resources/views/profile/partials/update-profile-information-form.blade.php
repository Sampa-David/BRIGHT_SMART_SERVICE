<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informations du profil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Mettez à jour les informations de votre profil et votre adresse email.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Nom -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nom') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" autocomplete="email" />
            <x-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Enregistré.') }}
        </x-action-message>

        <x-button>
            {{ __('Enregistrer') }}
        </x-button>
    </x-slot>
</x-form-section>