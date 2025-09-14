<?php

declare(strict_types=1);

use App\Models\Log;

it('belongs to a user', function (): void {
    $log = Log::factory()->create();

    expect($log->user()->exists())->toBeTrue();
});
