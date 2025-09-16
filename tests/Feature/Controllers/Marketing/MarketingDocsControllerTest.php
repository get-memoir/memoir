<?php

declare(strict_types=1);

it('returns ok response for docs index', function (): void {
    $response = $this->get('/docs')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api introduction', function (): void {
    $response = $this->get('/docs/api/introduction')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api authentication', function (): void {
    $response = $this->get('/docs/api/authentication')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api errors', function (): void {
    $response = $this->get('/docs/api/errors')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api profile', function (): void {
    $response = $this->get('/docs/api/profile')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api logs', function (): void {
    $response = $this->get('/docs/api/logs')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api api management', function (): void {
    $response = $this->get('/docs/api/api-management')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api genders', function (): void {
    $response = $this->get('/docs/api/genders')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api task categories', function (): void {
    $response = $this->get('/docs/api/task-categories')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api gifts', function (): void {
    $response = $this->get('/docs/api/gifts')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api tasks', function (): void {
    $response = $this->get('/docs/api/tasks')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api journals', function (): void {
    $response = $this->get('/docs/api/journals')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api entries', function (): void {
    $response = $this->get('/docs/api/entries')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api update age', function (): void {
    $response = $this->get('/docs/api/update-age')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api update physical appearance', function (): void {
    $response = $this->get('/docs/api/update-physical-appearance')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api notes', function (): void {
    $response = $this->get('/docs/api/notes')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for api life events', function (): void {
    $response = $this->get('/docs/api/life-events')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
