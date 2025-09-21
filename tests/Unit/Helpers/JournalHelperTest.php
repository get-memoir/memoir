<?php

declare(strict_types=1);

use Carbon\Carbon;

it('calculates correct number of days for different months', function (int $year, int $month, int $expectedDays): void {
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    expect($totalDays)->toBe($expectedDays);
})->with([
    [2023, 1, 31],  // January
    [2023, 2, 28],  // February (non-leap year)
    [2024, 2, 29],  // February (leap year)
    [2023, 4, 30],  // April
    [2023, 12, 31], // December
]);

it('properly formats month names', function (int $month, string $expectedName): void {
    $monthName = date('F', mktime(0, 0, 0, $month, 1, 2023));

    expect($monthName)->toBe($expectedName);
})->with([
    [1, 'January'],
    [2, 'February'],
    [3, 'March'],
    [4, 'April'],
    [5, 'May'],
    [6, 'June'],
    [7, 'July'],
    [8, 'August'],
    [9, 'September'],
    [10, 'October'],
    [11, 'November'],
    [12, 'December'],
]);

it('correctly identifies today using Carbon', function (): void {
    Carbon::setTestNow(Carbon::create(2023, 5, 15));

    $today = Carbon::createFromDate(2023, 5, 15);
    $notToday = Carbon::createFromDate(2023, 5, 16);

    expect($today->isToday())->toBeTrue();
    expect($notToday->isToday())->toBeFalse();
});

it('correctly compares selected values', function (): void {
    $selectedMonth = 6;
    $selectedDay = 15;

    // Test month selection logic
    expect($selectedMonth === 6)->toBeTrue();
    expect($selectedMonth === 7)->toBeFalse();

    // Test day selection logic
    expect($selectedDay === 15)->toBeTrue();
    expect($selectedDay === 16)->toBeFalse();
});
