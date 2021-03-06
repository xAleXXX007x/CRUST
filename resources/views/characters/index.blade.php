<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('characters.index') }}
    </h2>
  </x-slot>

  <x-character.list :characters="$characters">
    @can('create', App\Models\Character::class)
      <x-character.new :href="route('characters.create')"/>
    @endcan
  </x-character.list>

  @cannot('create', App\Models\Character::class)
    @if (!count($characters))
      <div class="text-gray-300 text-6xl text-center font-bold my-40">
        {{ __('characters.empty') }}
      </div>
    @endif
  @endcannot
</x-app-layout>
