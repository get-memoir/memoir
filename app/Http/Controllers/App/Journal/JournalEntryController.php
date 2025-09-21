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

        $months = JournalHelper::getMonths(
            journal: $journal,
            year: 2025,
            selectedMonth: 2,
        );

        $days = JournalHelper::getDaysInMonth(
            journal: $journal,
            year: 2025,
            month: 2,
            day: 1,
        );

        return view('journal.show', [
            'months' => $months,
            'days' => $days,
        ]);
    }
}
