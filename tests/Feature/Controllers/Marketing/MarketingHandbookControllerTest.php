<?php

declare(strict_types=1);

it('returns ok response for handbook index', function (): void {
    $response = $this->get('/company/handbook')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook project', function (): void {
    $response = $this->get('/company/handbook/project')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook principles', function (): void {
    $response = $this->get('/company/handbook/principles')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook shipping', function (): void {
    $response = $this->get('/company/handbook/shipping')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook money', function (): void {
    $response = $this->get('/company/handbook/money')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook why', function (): void {
    $response = $this->get('/company/handbook/why-open-source')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook where', function (): void {
    $response = $this->get('/company/handbook/where-am-I-going-with-this')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook marketing', function (): void {
    $response = $this->get('/company/handbook/marketing')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook social media', function (): void {
    $response = $this->get('/company/handbook/social-media')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook writing', function (): void {
    $response = $this->get('/company/handbook/writing')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook prioritize', function (): void {
    $response = $this->get('/company/handbook/prioritize')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('returns ok response for handbook philosophy', function (): void {
    $response = $this->get('/company/handbook/product-philosophy')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
