<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Journal\Settings;

use App\Actions\UpdateJournalName;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class JournalSettingsController extends Controller
{
    public function index(Request $request): View
    {
        $journal = $request->attributes->get('journal');

        return view('journal.settings.index', [
            'journal' => $journal,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'journal_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-_]+$/',
            ],
        ]);

        $journal = new UpdateJournalName(
            user: Auth::user(),
            journal: $request->attributes->get('journal'),
            name: $validated['journal_name'],
        )->execute();

        return redirect()->route('journal.settings.index', $journal->slug)
            ->with('status', __('Changes saved'));
    }
}
