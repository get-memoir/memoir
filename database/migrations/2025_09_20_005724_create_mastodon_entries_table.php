<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mastodon_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('mastodon_username');
            $table->text('content');
            $table->text('url');
            $table->datetime('published_at');
            $table->timestamps();

            $table->index(['mastodon_username']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mastodon_entries');
    }
};
