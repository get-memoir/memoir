<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Journal;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

final class JournalEntryController extends Controller
{
    public function show(Request $request): View
    {
        return view('journal.show', [
            'journal' => $request->attributes->get('journal'),
        ]);
    }
}
