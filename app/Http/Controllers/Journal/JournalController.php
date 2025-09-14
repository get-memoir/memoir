<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Actions\CreateJournal;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Journal\JournalIndexViewModel;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

final class JournalController extends Controller
{
    public function index(): View
    {
        $viewModel = new JournalIndexViewModel(
            user: Auth::user(),
        );

        return view('journal.index', [
            'viewModel' => $viewModel,
        ]);
    }

    public function create(): View
    {
        return view('journal.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'journal_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-_]+$/',
            ],
        ]);

        $journal = new CreateJournal(
            user: Auth::user(),
            name: $validated['journal_name'],
        )->execute();

        return redirect()->route('journal.show', $journal->slug)
            ->with('status', __('Journal created successfully'));
    }

    public function show(Request $request): View
    {
        return view('journal.show', [
            'journal' => $request->attributes->get('journal'),
        ]);
    }
}
