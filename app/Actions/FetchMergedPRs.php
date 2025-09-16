<?php

declare(strict_types=1);

namespace App\Actions;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

final class FetchMergedPRs
{
    private const int DESIRED_COUNT = 10;

    /**
     * @var array<int, array<string, mixed>>
     */
    private array $pullRequests = [];

    public function __construct(private readonly Client $client = new Client()) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function execute(): array
    {
        $this->fetch();
        $this->format();

        return $this->pullRequests;
    }

    private function fetch(): void
    {
        $owner = 'get-memoir';
        $repo = 'memoir';
        $token = config('memoir.github_token');

        $merged = [];
        $page = 1;
        $perPage = 50;
        $maxPages = 10;

        while (count($merged) < self::DESIRED_COUNT && $page <= $maxPages) {
            $response = $this->client->request('GET', "https://api.github.com/repos/{$owner}/{$repo}/pulls", [
                'headers' => [
                    'Authorization' => $token ? "token {$token}" : null,
                    'Accept' => 'application/vnd.github.v3+json',
                ],
                'query' => [
                    'state' => 'closed',
                    'sort' => 'updated',
                    'direction' => 'desc',
                    'per_page' => $perPage,
                    'page' => $page,
                ],
            ]);

            $batch = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            if (empty($batch)) {
                break; // no more results
            }

            foreach ($batch as $pr) {
                if (!empty($pr['merged_at'])) {
                    $merged[] = $pr;
                    if (count($merged) >= self::DESIRED_COUNT) {
                        break 2;
                    }
                }
            }

            $page++;
        }

        $this->pullRequests = array_slice($merged, 0, self::DESIRED_COUNT);
    }

    private function format(): void
    {
        $this->pullRequests = array_map(fn(array $pr): array => [
            'title' => $pr['title'],
            'number' => $pr['number'],
            'body' => str_replace(
                ["'", "\n", "\r", 'é', 'è', 'à', 'ù'],
                ["\\'", '\\n', '', 'e', 'e', 'a', 'u'],
                Str::markdown($pr['body'] ?? 'No description provided.'),
            ),
            'merged_at' => $pr['merged_at'] ? now()->parse($pr['merged_at'])->diffForHumans() : null,
            'url' => "https://github.com/get-memoir/memoir/pull/{$pr['number']}",
        ], $this->pullRequests);
    }
}
