<?php

declare(strict_types=1);

use App\Models\EmailSent;
use App\Models\Journal;
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
