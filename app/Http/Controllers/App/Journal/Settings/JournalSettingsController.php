<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Journal\Settings;

use App\Models\Journal;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

final class JournalSettingsController extends Controller
{
    public function index(Request $request): View
    {
        $journal = $request->attributes->get('journal');

        return view('journal.settings.index', [
            'journal' => $journal,
        ]);
    }
}
