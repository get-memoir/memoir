<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * This controller is used to handle the marketing documentation pages.
 * It should be one of the only controllers that does not follow the naming convention
 * for methods in a controller.
 */
final class MarketingDocsController extends Controller
{
    public function index(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.index', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function introduction(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.introduction', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function authentication(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.authentication', [
            'marketingPage' => $marketingPage,
        ]);
    }
}
