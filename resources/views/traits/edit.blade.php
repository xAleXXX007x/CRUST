<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('traits.edit') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('traits.update', $trait) }}">
      @csrf
      @method('PATCH')

      <x-form.card>
        <x-form.input name="name" required maxlength="256" placeholder="{{ __('traits.placeholder.name') }}" :value="old('name', $trait->name)" />
        <x-form.textarea name="description" maxlength="1024" required onfocus="preview(this)" placeholder="{{ __('traits.placeholder.description') }}" wrap="off">
          {{ old('description', $trait->description) }}
        </x-form.textarea>
        <x-form.textarea name="races" maxlength="512" required placeholder="{{ __('traits.placeholder.races') }}" wrap="off">
          {{ old('races', $trait->races) }}
        </x-form.textarea>
        <x-form.checkbox name="subtrait" value="{{ old('subtrait', false) }}" />

        <x-button>
          {{ __('ui.submit') }}
        </x-button>
      </x-form.card>
    </form>
    <script>
      var previewText = @json(__('label.preview'))
    </script>
  </x-container>
</x-app-layout>