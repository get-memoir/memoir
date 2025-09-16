<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Settings;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class AccountController extends Controller
{
    public function index(): View
    {
        return view('settings.emails.index');
    }
}
