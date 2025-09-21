<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Settings;

use App\Actions\DestroyAccount;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AccountController extends Controller
{
    public function index(): View
    {
        return view('settings.account.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        new DestroyAccount(
            user: $request->user(),
        )->execute();

        return redirect()->route('login');
    }
}
