<?php

declare(strict_types=1);

use App\Http\Controllers\App\LocaleController;
use App\Http\Controllers\App\Journal;
use App\Http\Controllers\App\Settings;
use App\Http\Controllers\Marketing;
use Illuminate\Support\Facades\Route;

Route::put('/locale', [LocaleController::class, 'update'])->name('locale.update');

Route::middleware(['marketing.page'])->group(function (): void {
    Route::get('/', [Marketing\MarketingController::class, 'index'])->name('marketing.index');
    Route::get('/about', [Marketing\MarketingController::class, 'index'])->name('marketing.about.index');
    Route::get('/why', [Marketing\MarketingWhyController::class, 'index'])->name('marketing.why.index');
    Route::get('/pricing', [Marketing\MarketingPricingController::class, 'index'])->name('marketing.pricing.index');
    Route::get('/company', [Marketing\MarketingCompanyController::class, 'index'])->name('marketing.company.index');
    Route::get('/privacy', [Marketing\MarketingPrivacyController::class, 'index'])->name('marketing.privacy.index');
    Route::get('/terms', [Marketing\MarketingTermsController::class, 'index'])->name('marketing.terms.index');
    Route::get('/company/handbook', [Marketing\MarketingHandbookController::class, 'index'])->name('marketing.company.handbook.index');
    Route::get('/company/handbook/project', [Marketing\MarketingHandbookController::class, 'project'])->name('marketing.company.handbook.project');
    Route::get('/company/handbook/principles', [Marketing\MarketingHandbookController::class, 'principles'])->name('marketing.company.handbook.principles');
    Route::get('/company/handbook/shipping', [Marketing\MarketingHandbookController::class, 'shipping'])->name('marketing.company.handbook.shipping');
    Route::get('/company/handbook/money', [Marketing\MarketingHandbookController::class, 'money'])->name('marketing.company.handbook.money');
    Route::get('/company/handbook/why-open-source', [Marketing\MarketingHandbookController::class, 'why'])->name('marketing.company.handbook.why-open-source');
    Route::get('/company/handbook/where-am-I-going-with-this', [Marketing\MarketingHandbookController::class, 'where'])->name('marketing.company.handbook.where');
    Route::get('/company/handbook/marketing', [Marketing\MarketingHandbookController::class, 'marketing'])->name('marketing.company.handbook.marketing.envision');
    Route::get('/company/handbook/social-media', [Marketing\MarketingHandbookController::class, 'socialMedia'])->name('marketing.company.handbook.marketing.social-media');
    Route::get('/company/handbook/writing', [Marketing\MarketingHandbookController::class, 'writing'])->name('marketing.company.handbook.marketing.writing');
    Route::get('/company/handbook/product-philosophy', [Marketing\MarketingHandbookController::class, 'philosophy'])->name('marketing.company.handbook.marketing.product-philosophy');
    Route::get('/company/handbook/prioritize', [Marketing\MarketingHandbookController::class, 'prioritize'])->name('marketing.company.handbook.marketing.prioritize');

    // docs
    Route::get('/docs', [Marketing\MarketingDocsController::class, 'index'])->name('marketing.docs.index');
    Route::get('/docs/concepts/hierarchical-structure', [Marketing\Docs\Concepts\HierarchicalStructureController::class, 'index'])->name('marketing.docs.concepts.hierarchical-structure');
    Route::get('/docs/api/introduction', [Marketing\MarketingDocsController::class, 'introduction'])->name('marketing.docs.api.introduction');
    Route::get('/docs/api/authentication', [Marketing\MarketingDocsController::class, 'authentication'])->name('marketing.docs.api.authentication');
    Route::get('/docs/api/errors', [Marketing\MarketingDocsController::class, 'errors'])->name('marketing.docs.api.errors');
    Route::get('/docs/api/profile', [Marketing\MarketingDocsController::class, 'profile'])->name('marketing.docs.api.profile');
    Route::get('/docs/api/logs', [Marketing\MarketingDocsController::class, 'logs'])->name('marketing.docs.api.logs');
    Route::get('/docs/api/api-management', [Marketing\MarketingDocsController::class, 'apiManagement'])->name('marketing.docs.api.api-management');
    Route::get('/docs/api/journals', [Marketing\MarketingDocsController::class, 'journals'])->name('marketing.docs.api.journals');
    Route::get('/docs/api/entries', [Marketing\MarketingDocsController::class, 'entries'])->name('marketing.docs.api.entries');
});

Route::middleware(['auth', 'verified', 'throttle:60,1', 'set.locale'])->group(function (): void {
    // marketing
    Route::post('/vote/{page}/helpful', [Marketing\MarketingVoteHelpfulController::class, 'update'])->name('marketing.vote-helpful');
    Route::post('/vote/{page}/unhelpful', [Marketing\MarketingVoteUnhelpfulController::class, 'update'])->name('marketing.vote-unhelpful');
    Route::delete('/vote/{page}', [Marketing\MarketingVoteController::class, 'update'])->name('marketing.destroy-vote');

    // journal
    Route::get('journals', [Journal\JournalController::class, 'index'])->name('journal.index');
    Route::get('journals/create', [Journal\JournalController::class, 'create'])->name('journal.create');
    Route::post('journals', [Journal\JournalController::class, 'store'])->name('journal.store');

    // journal
    Route::middleware(['journal'])->group(function (): void {
        Route::get('journals/{slug}', [Journal\JournalController::class, 'show'])->name('journal.show');
        Route::get('journals/{slug}/settings', [Journal\Settings\JournalSettingsController::class, 'index'])->name('journal.settings.index');

        Route::middleware(['journal.entry'])->group(function (): void {
            Route::get('journals/{slug}/entries/{year}/{month}/{day}', [Journal\JournalEntryController::class, 'show'])->name('journal.entry.show');
        });
    });

    // settings redirect
    Route::redirect('settings', 'settings/profile');

    // settings
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.index');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');

    // logs
    Route::get('settings/profile/logs', [Settings\LogController::class, 'index'])->name('settings.logs.index');

    // emails
    Route::get('settings/profile/emails', [Settings\EmailSentController::class, 'index'])->name('settings.emails.index');

    // security
    Route::get('settings/security', [Settings\Security\SecurityController::class, 'index'])->name('settings.security.index');
    Route::put('settings/password', [Settings\Security\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\Security\AppearanceController::class, 'edit'])->name('settings.appearance.edit');

    // api keys
    Route::get('settings/api-keys/create', [Settings\Security\ApiKeyController::class, 'create'])->name('settings.api-keys.create');
    Route::post('settings/api-keys', [Settings\Security\ApiKeyController::class, 'store'])->name('settings.api-keys.store');
    Route::delete('settings/api-keys/{apiKey}', [Settings\Security\ApiKeyController::class, 'destroy'])->name('settings.api-keys.destroy');

    // delete account
    Route::get('settings/account', [Settings\AccountController::class, 'index'])->name('settings.account.index');
    Route::delete('settings/account', [Settings\AccountController::class, 'destroy'])->name('settings.account.destroy');
});

require __DIR__ . '/auth.php';
