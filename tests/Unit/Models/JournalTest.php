<?php

declare(strict_types=1);

use App\Models\Journal;

it('belongs to a user', function (): void {
    $journal = Journal::factory()->create();

    expect($journal->user()->exists())->toBeTrue();
});

it('gets the avatar', function (): void {
    $journal = Journal::factory()->create();

    expect($journal->avatar())->toBeString();
});
