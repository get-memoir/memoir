<?php

declare(strict_types=1);

namespace App\Http\Controllers\App;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

final class LocaleController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', 'string', Rule::in(config('memoir.supported_locales'))],
        ]);

        App::setLocale($validated['locale']);
        session()->put('locale', $validated['locale']);

        if (Auth::check()) {
            Auth::user()->update(['locale' => $validated['locale']]);
        }

        return redirect()->back()
            ->with('status', __('Locale updated'));
    }
}
