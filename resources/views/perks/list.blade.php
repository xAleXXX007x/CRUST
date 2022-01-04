<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
  </head>
  <body class="font-sans antialiased bg-gray-100">
    <div class="p-2 bg-white">
      <x-search-field :search="$search" :route="route('perks.list')"/>
      <div class="flex space-x-2 mt-2 ml-2 text-sm">
        <div class="text-gray-500">
          {{ __('ui.sort.title') }}:
        </div>
  
        @php
          $cost_order = app('request')->input('cost_order') == 'desc';
        @endphp
  
        <a class="text-blue-400" href="{{ route('perks.list', [ 'cost_order' => $cost_order ? 'asc' : 'desc' ]) }}">{{ __('ui.sort.cost') }} {{ $cost_order ? '↓' : '↑' }}</a>
      </div>
    </div>
    <div class="p-6 space-y-4">
      @foreach ($perks as $perk)
        <div class="border border-gray-400 rounded-xl overflow-hidden">
          <div class="flex justify-between border-b bg-gray-100 border-gray-400">
            <div class="flex items-center font-bold text-lg py-2 px-3 uppercase space-x-2">
              {{ $perk->name }}
            </div>
            <div class="p-2 text-center font-bold text-lg border-gray-400 border-l">
              {{ $perk->cost }}
            </div>
          </div>
          <div class="flex bg-gray-50 border-b border-gray-400 px-2 py-1 space-x-2 uppercase font-bold text-sm  ">
            @if ($perk->type->isCombat())
              <div class="bg-red-100 px-2 rounded-full">
                {{ __('perks.types.combat') }}
              </div>
            @else
            <div class="bg-green-100 px-2 rounded-full">
              {{ __('perks.types.noncombat') }}
            </div>
            @endif

            @if ($perk->type->hasFlag(App\Enums\PerkType::Native))
              <div class="bg-purple-100 px-2 rounded-full">
                {{ __('perks.types.native') }}
              </div>
            @endif

            @if ($perk->type->hasFlag(App\Enums\PerkType::Unique))
              <div class="bg-yellow-100 px-2 rounded-full">
                {{ __('perks.types.unique') }}
              </div>
            @endif
          </div>
          <div class="divide-y divide-dashed">
            @foreach ($perk->variants as $perkVariant)
              <div class="prose markdown p-2">{!! $perkVariant->description !!}</div>
            @endforeach
          </div>
        </div>
      @endforeach

      {{ $perks->links() }}
    </div>
  </body>
</html>