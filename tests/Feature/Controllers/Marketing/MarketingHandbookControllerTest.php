<?php

declare(strict_types=1);

it('shows the handbook index page', function (): void {
    $response = $this->get('/company/handbook')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook project page', function (): void {
    $response = $this->get('/company/handbook/project')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook principles page', function (): void {
    $response = $this->get('/company/handbook/principles')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook shipping page', function (): void {
    $response = $this->get('/company/handbook/shipping')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook money page', function (): void {
    $response = $this->get('/company/handbook/money')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook why page', function (): void {
    $response = $this->get('/company/handbook/why-open-source')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook where page', function (): void {
    $response = $this->get('/company/handbook/where-am-I-going-with-this')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook marketing page', function (): void {
    $response = $this->get('/company/handbook/marketing')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook social media page', function (): void {
    $response = $this->get('/company/handbook/social-media')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook writing page', function (): void {
    $response = $this->get('/company/handbook/writing')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook prioritize page', function (): void {
    $response = $this->get('/company/handbook/prioritize')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});

it('shows the handbook philosophy page', function (): void {
    $response = $this->get('/company/handbook/product-philosophy')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
