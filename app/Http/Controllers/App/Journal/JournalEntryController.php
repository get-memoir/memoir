<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Journal;

use App\Helpers\JournalHelper;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

final class JournalEntryController extends Controller
{
    public function show(Request $request): View
    {
        $journal = $request->attributes->get('journal');
        $journalEntry = $request->attributes->get('journal_entry');

        $months = JournalHelper::getMonths(
            journal: $journal,
            year: $journalEntry->year,
            selectedMonth: $journalEntry->month,
        );

        $days = JournalHelper::getDaysInMonth(
            journal: $journal,
            year: $journalEntry->year,
            month: $journalEntry->month,
            day: $journalEntry->day,
        );

        return view('journal.show', [
            'journal' => $journal,
            'months' => $months,
            'days' => $days,
        ]);
    }
}
