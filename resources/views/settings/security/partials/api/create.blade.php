<x-form id="new-api-key-form" x-target="api-key-list new-api-key-form api-key-notification notifications" x-target.back="new-api-key-form" action="{{ route('settings.api-keys.store') }}" method="post" class="space-y-5 rounded-t-lg p-4 first:rounded-t-lg last:rounded-b-lg last:border-0 hover:bg-blue-50">
  <div>
    <x-input id="key" :label="__('Label for the API key')" type="text" name="key" required autofocus :error="$errors->get('key')" />
  </div>

  <div class="flex justify-between">
    <x-button.secondary href="{{ route('settings.security.index') }}" enable-turbo="true" x-target="new-api-key-form">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button class="mr-2" data-test="create-api-key-button">
      {{ __('Create') }}
    </x-button>
  </div>
</x-form>
