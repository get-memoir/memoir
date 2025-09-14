<?php

declare(strict_types=1);

use App\Models\Journal;
use App\Models\Organization;
use App\Models\User;

it('shows the journals the user has', function (): void {
    $user = User::factory()->create();
    Journal::factory()->create([
        'user_id' => $user->id,
        'name' => 'Dunder Mifflin',
        'slug' => 'dunder-mifflin',
    ]);
    $response = $this->actingAs($user)->get('/journals');

    $response->assertStatus(200);
    $response->assertSee('Dunder Mifflin');
});

it('shows a message when the user does not have any journals', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/journals');

    $response->assertStatus(200);
    $response->assertSee('You do not have any journals yet.');
});

it('creates a journal', function (): void {
    $user = User::factory()->create([
        'email' => 'michael.scott@dundermifflin.com',
        'password' => Illuminate\Support\Facades\Hash::make('5UTHSmdj'),
    ]);

    $this->actingAs($user)->get('/journals/create');

    $response = $this->post('/journals', [
        'journal_name' => 'Dunder Mifflin',
    ]);

    $journal = Journal::where('name', 'Dunder Mifflin')->first();

    $response->assertRedirect('/journals/' . $journal->slug);
});

it('lets an user access a journal', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
    ]);
    $response = $this->actingAs($user)->get('/journals/' . $journal->slug);
    $response->assertStatus(200);
});

it('does not let an user access a journal they are not a member of', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create();

    $response = $this->actingAs($user)->get('/journals/' . $journal->slug);

    $response->assertStatus(403);
});
