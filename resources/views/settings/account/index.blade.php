<x-app-layout>
  <x-slot:title>
    {{ __('Danger zone') }}
  </x-slot>

  <x-breadcrumb :items="[
    ['label' => __('Dashboard'), 'route' => route('journal.index')],
    ['label' => __('Settings'), 'route' => route('settings.profile.index')],
    ['label' => __('Danger zone')]
  ]" />

  <!-- settings layout -->
  <div class="grid flex-grow sm:grid-cols-[220px_1fr]">
    <!-- Sidebar -->
    @include('settings.partials.sidebar')

    <!-- Main content -->
    <section class="p-4 sm:p-8">
      <div class="mx-auto flex max-w-xl flex-col gap-y-8 sm:px-0">
        <x-box :title="__('Need to cancel your account?')">
          <div class="mb-4 space-y-2">
            <p class="text-sm text-gray-500">{{ __('We\'ll be sorry to see you go, but you can cancel your account at any time.') }}</p>
            <p class="text-sm text-gray-500">{{ __('All your data will be deleted immediately and cannot be restored. This is irreversible. Please be certain.') }}</p>
          </div>

          <x-form
            action="{{ route('settings.account.destroy') }}"
            method="delete"
            class="space-y-2"
            x-data="{
              feedback: '',
              isValid: false,
              async handleSubmit() {
                if (! this.isValid) return

                if (
                  await confirm(
                    '{{ __('Are you absolutely sure? This action cannot be undone.') }}',
                  )
                ) {
                  $el.submit()
                }
              },
            }"
            @submit.prevent="handleSubmit">
            <label for="feedback" class="block text-sm font-medium text-red-700">
              {{ __('Please tell us why you are leaving (required)') }}
            </label>

            <textarea id="feedback" name="feedback" rows="3" x-model="feedback" @input="isValid = feedback.length >= 3" class="block w-full appearance-none rounded-lg border border-gray-200 border-b-gray-300/80 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-xs disabled:border-b-gray-200 disabled:text-gray-500 disabled:placeholder-gray-400/70 disabled:shadow-none aria-invalid:border-red-500 dark:border-white/10 dark:bg-white/10 dark:text-gray-300 dark:placeholder-gray-400 dark:shadow-none dark:disabled:border-white/5 dark:disabled:bg-white/[7%] dark:disabled:text-gray-400 dark:disabled:placeholder-gray-500" placeholder="{{ __('Your feedback helps us improve our service...') }}"></textarea>

            <div class="flex items-center justify-end gap-x-3">
              <button type="submit" x-bind:disabled="!isValid" x-bind:class="! isValid ? 'opacity-50 cursor-not-allowed' : ''" class="inline-flex items-center gap-x-2 rounded-md bg-red-600 px-3.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-red-600">
                <x-phosphor-trash class="h-4 w-4" />
                {{ __('Delete my account') }}
              </button>
            </div>
          </x-form>
        </x-box>
      </div>
    </section>
  </div>
</x-app-layout>
