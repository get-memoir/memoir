<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
  <head>
    @include('partials.head')
  </head>
  <body class="layout sidebar min-h-screen bg-white text-gray-700 dark:bg-gray-800 dark:text-gray-300">
    <x-sidebar sticky stashable class="border-r border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
      <x-sidebar.toggle class="w-10 p-0 lg:hidden">
        <x-phosphor-x aria-hidden="true" width="20" height="20" />
      </x-sidebar.toggle>

      <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2">
        <x-app-logo />
      </a>

      <x-navlist>
        <x-navlist.group :heading="__('Platform')">
          <x-navlist.item before="phosphor-house-line" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
          </x-navlist.item>
        </x-navlist.group>
      </x-navlist>

      <x-spacer />

      <x-navlist>
        <x-navlist.item before="phosphor-git-pull-request" href="https://github.com/imacrayon/blade-starter-kit" target="_blank">
          {{ __('Repository') }}
        </x-navlist.item>

        <x-navlist.item before="phosphor-book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
          {{ __('Documentation') }}
        </x-navlist.item>
      </x-navlist>

      <x-popover align="bottom" justify="left">
        <button type="button" class="group flex w-full items-center rounded-lg p-1 hover:bg-gray-800/5 dark:hover:bg-white/10">
          <span class="size-8 shrink-0 overflow-hidden rounded-sm bg-gray-200 dark:bg-gray-700">
            <span class="flex h-full w-full items-center justify-center text-sm">
              {{ auth()->user()->initials() }}
            </span>
          </span>
          <span class="ml-2 truncate text-sm font-medium text-gray-500 group-hover:text-gray-800 dark:text-white/80 dark:group-hover:text-white">
            {{ auth()->user()->name }}
          </span>
          <span class="ml-auto flex size-8 shrink-0 items-center justify-center">
            <x-phosphor-caret-up-down aria-hidden="true" width="16" height="16" class="text-gray-400 group-hover:text-gray-800 dark:text-white/80 dark:group-hover:text-white" />
          </span>
        </button>
        <x-slot:menu class="w-max">
          <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
              <span class="flex h-full w-full items-center justify-center rounded-lg bg-gray-200 text-black dark:bg-gray-700 dark:text-white">
                {{ auth()->user()->initials() }}
              </span>
            </span>

            <div class="grid flex-1 text-left text-sm leading-tight">
              <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
              <span class="truncate text-xs">{{ auth()->user()->email }}</span>
            </div>
          </div>
          <x-popover.separator />
          <x-popover.item before="phosphor-gear-fine" href="/settings/profile">{{ __('Settings') }}</x-popover.item>
          <x-popover.separator />
          <x-form method="post" action="{{ route('logout') }}" class="flex w-full">
            <x-popover.item before="phosphor-sign-out">{{ __('Log Out') }}</x-popover.item>
          </x-form>
        </x-slot>
      </x-popover>
    </x-sidebar>

    <!-- Mobile User Menu -->
    <x-header class="lg:hidden">
      <x-container class="flex min-h-14 items-center">
        <x-sidebar.toggle class="w-10 p-0 lg:hidden">
          <x-phosphor-list aria-hidden="true" width="20" height="20" />
        </x-sidebar.toggle>

        <x-spacer />

        <x-popover align="top" justify="right">
          <button type="button" class="group flex w-full items-center rounded-lg p-1 hover:bg-gray-800/5 dark:hover:bg-white/10">
            <span class="size-8 shrink-0 overflow-hidden rounded-sm bg-gray-200 dark:bg-gray-700">
              <span class="flex h-full w-full items-center justify-center text-sm">
                {{ auth()->user()->initials() }}
              </span>
            </span>
            <span class="ml-auto flex size-8 shrink-0 items-center justify-center">
              <x-phosphor-caret-down width="16" height="16" class="text-gray-400 group-hover:text-gray-800 dark:text-white/80 dark:group-hover:text-white" />
            </span>
          </button>
          <x-slot:menu>
            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
              <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                <span class="flex h-full w-full items-center justify-center rounded-lg bg-gray-200 text-black dark:bg-gray-700 dark:text-white">
                  {{ auth()->user()->initials() }}
                </span>
              </span>
              <div class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
              </div>
            </div>
            <x-popover.separator />
            <x-popover.item before="phosphor-gear-fine" href="/settings/profile">{{ __('Settings') }}</x-popover.item>
            <x-popover.separator />
            <x-form method="post" action="{{ route('logout') }}" class="flex w-full">
              <x-popover.item before="phosphor-sign-out">{{ __('Log Out') }}</x-popover.item>
            </x-form>
          </x-slot>
        </x-popover>
      </x-container>
    </x-header>

    {{ $slot }}
  </body>
</html>
