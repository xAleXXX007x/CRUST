<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('characters.all') }}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto">
    <div class="mt-6 bg-white mx-auto shadow-lg p-4 rounded-xl">
      <x-search-field :search="$search" :route="route('characters.all')"/>
      <div class="flex space-x-2 mt-2 ml-2 text-sm">
        <div class="text-gray-500">
          {{ __('ui.sort.title') }}:
        </div>

        @php
          $created_at_order = app('request')->input('created_at') == 'desc';
          $updated_at_order = app('request')->input('updated_at') == 'desc';
        @endphp

        <a class="text-blue-400" href="{{ route('characters.all', [ 'created_at' => $created_at_order ? 'asc' : 'desc' ]) }}">{{ __('ui.sort.created_at') }} {{ $created_at_order ? '↓' : '↑' }}</a>
        <a class="text-blue-400" href="{{ route('characters.all', [ 'updated_at' => $updated_at_order ? 'asc' : 'desc' ]) }}">{{ __('ui.sort.updated_at') }} {{ $updated_at_order ? '↓' : '↑' }}</a>
      </div>
    </div>

    @if (count($characters))
      <div class="grid gap-4 grid-cols-3 mt-4">
        @foreach ($characters as $character)
          <a href="{{ route('characters.show', $character) }}" class="bg-white rounded-xl flex-none overflow-hidden shadow-lg transition duration-150 ease-in-out transform hover:-translate-y-2 hover:scale-105">
            <div class="flex">
              <img
                class="object-cover object-top h-36 w-36"
                src="{{ Storage::url($character->reference).'?='.$character->updated_at }}"
                alt="Character Reference"
              >
              <div class="ml-2 p-2 my-auto">
                <div class="font-bold text-lg line-clamp-2">
                  {{$character->name}}
                </div>
                <div class="text-gray-700">
                  {{$character->login}}, {{$character->user->discord_tag}}
                </div>
                <div class="text-sm text-gray-400">
                  {{Carbon\Carbon::parse($character->updated_at)->diffForHumans()}}
                </div>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    @else
      <div class="text-gray-300 text-6xl text-center font-bold my-40">
        {{ __('characters.empty') }}
      </div>
    @endif

    <div class="mt-4 mb-8">
      {{ $characters->appends(request()->query())->links() }}
    </div>
  </div>
</x-app-layout>
