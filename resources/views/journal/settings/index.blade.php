<x-app-layout>
  <x-slot:title>
    {{ __('Journal') }}
  </x-slot>

  <x-breadcrumb :items="[
    ['label' => __('Dashboard'), 'route' => route('journal.index')],
    ['label' => $journal->name, 'route' => route('journal.show', $journal->slug)],
    ['label' => __('Settings')]
  ]" />

<div class="px-6 pt-6">
  <div class="mx-auto w-full max-w-2xl items-start justify-center">
    <x-box :title="__('Settings')" padding="p-0">
      <x-slot:description>
        <p>{{ __('Here all the settings for the journal are listed.') }}</p>
      </x-slot>

      <x-form method="put" action="{{ route('settings.password.update') }}">
    <!-- current password -->
    <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
      <p class="col-span-2 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Journal name') }}</p>
      <div class="w-full justify-self-end">
        <x-input id="journal_name" value="{{ old('journal_name', $journal->name) }}" required :error="$errors->get('journal_name')" placeholder="{{ __('Life journal') }}" autofocus />
      </div>
    </div>

    <div class="flex items-center justify-end p-3">
      <x-button>{{ __('Save') }}</x-button>
    </div>
  </x-form>
    </x-box>
  </div>
</div>

</x-app-layout>
