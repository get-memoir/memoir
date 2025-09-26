<?php

declare(strict_types=1);

use App\Models\EmailSent;
use App\Models\Journal;
use App\Models\JournalEntryMastodon;
use App\Models\MarketingPage;
use App\Models\User;

it('has many journals', function (): void {
    $user = User::factory()->create();
    Journal::factory()->count(2)->create([
        'user_id' => $user->id,
    ]);

    expect($user->journals)->toHaveCount(2);
});

it('has many emails sent', function (): void {
    $user = User::factory()->create();
    EmailSent::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($user->emailsSent()->exists())->toBeTrue();
});

it('has many journal entry mastodon', function (): void {
    $user = User::factory()->create();
    JournalEntryMastodon::factory()->count(2)->create([
        'user_id' => $user->id,
    ]);

    expect($user->journalEntryMastodon)->toHaveCount(2);
});

it('has many marketing pages', function (): void {
    $user = User::factory()->create();
    $marketingPage = MarketingPage::factory()->create();
    $marketingPage->users()->attach($user);

    expect($user->marketingPages()->exists())->toBeTrue();
});

it('gets the name', function (): void {
    $user = User::factory()->create([
        'first_name' => 'Dwight',
        'last_name' => 'Schrute',
        'nickname' => null,
    ]);

    expect($user->getFullName())->toEqual('Dwight Schrute');

    $user->nickname = 'The Beet Farmer';
    $user->save();
    expect($user->getFullName())->toEqual('The Beet Farmer');
});

it('has initials', function (): void {
    $dwight = User::factory()->create([
        'first_name' => 'Dwight',
        'last_name' => 'Schrute',
    ]);

    expect($dwight->initials())->toEqual('DS');
});
