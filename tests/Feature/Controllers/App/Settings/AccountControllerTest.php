<?php

declare(strict_types=1);

use App\Models\User;

it('shows the account management page', function (): void {
    $this->actingAs(User::factory()->create());

    $this->get('/settings/account')->assertOk();
});

it('deletes the account', function (): void {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/settings/account', [
            'feedback' => 'I am leaving because I am not happy with the service.',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/login');
});
