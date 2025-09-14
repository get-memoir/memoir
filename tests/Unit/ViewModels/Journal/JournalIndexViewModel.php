<?php

declare(strict_types=1);

use App\Http\ViewModels\Journal\JournalIndexViewModel;
use App\Models\User;
use App\Models\Journal;

it('returns the correct journals', function (): void {
    $user = User::factory()->create();
    $journal1 = Journal::factory()->create([
        'name' => 'Dunder Mifflin',
        'slug' => 'dunder-mifflin',
    ]);
    $journal2 = Journal::factory()->create([
        'name' => 'Dunder Mifflin Paper Company',
        'slug' => 'dunder-mifflin-paper-company',
    ]);

    $user->journals()->attach($journal1->id, [
        'joined_at' => now(),
    ]);
    $user->journals()->attach($journal2->id, [
        'joined_at' => now(),
    ]);

    $viewModel = new JournalIndexViewModel(
        user: $user,
    );

    $journals = $viewModel->journals();

    expect($journals)->toHaveCount(2);

    $firstJournal = $journals->first();
    expect(property_exists($firstJournal, 'id'))->toBeTrue();
    expect(property_exists($firstJournal, 'name'))->toBeTrue();
    expect(property_exists($firstJournal, 'slug'))->toBeTrue();
    expect(property_exists($firstJournal, 'avatar'))->toBeTrue();

    expect($firstJournal->id)->toEqual($journal1->id);
    expect('Dunder Mifflin')->toEqual($journal1->name);
});
