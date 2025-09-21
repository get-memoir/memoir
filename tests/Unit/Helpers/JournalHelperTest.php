<?php

declare(strict_types=1);

use App\Helpers\JournalHelper;
use App\Models\Journal;
use Carbon\Carbon;

it('gets all months in a given year', function (): void {
    Carbon::setTestNow(Carbon::create(2023, 2, 1));
    $journal = Journal::factory()->create();

    $collection = JournalHelper::getMonths(
        journal: $journal,
        year: 2023,
        selectedMonth: 2,
    );

    expect($collection)->toHaveCount(12);
    expect($collection[2])->toEqual([
        'month' => 2,
        'month_name' => 'February',
        'entries_count' => 0,
        'is_selected' => true,
        'url' => env('APP_URL') . '/journals/' . $journal->slug . '/entries/2023/2/1',
    ]);
});
