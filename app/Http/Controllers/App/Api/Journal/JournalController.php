<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Api\Journal;

use App\Http\Resources\JournalResource;
use App\Actions\CreateJournal;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;

final class JournalController extends Controller
{
    use ApiResponses;

    public function index(): AnonymousResourceCollection
    {
        $journals = Auth::user()->journals;

        return JournalResource::collection($journals);
    }

    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $journal = new CreateJournal(
            user: Auth::user(),
            name: $validated['name'],
        )->execute();

        return new JournalResource($journal)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request): JsonResponse
    {
        $journal = $request->attributes->get('journal');

        return new JournalResource($journal)
            ->response()
            ->setStatusCode(200);
    }
}
