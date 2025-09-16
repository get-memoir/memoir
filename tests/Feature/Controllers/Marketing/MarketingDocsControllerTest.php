<?php

declare(strict_types=1);

it('shows the docs index page', function (): void {
    $response = $this->get('/docs')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the api introduction page', function (): void {
    $response = $this->get('/docs/api/introduction')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the api authentication page', function (): void {
    $response = $this->get('/docs/api/authentication')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the api errors page', function (): void {
    $response = $this->get('/docs/api/errors')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the api profile page', function (): void {
    $response = $this->get('/docs/api/profile')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the api logs page', function (): void {
    $response = $this->get('/docs/api/logs')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the api api management page', function (): void {
    $response = $this->get('/docs/api/api-management')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
