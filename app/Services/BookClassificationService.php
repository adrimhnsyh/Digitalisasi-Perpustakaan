<?php

namespace App\Services;

use App\Models\KlasifikasiBuku;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BookClassificationService
{
    /**
     * @param  array<string, mixed>  $bookData
     * @return array<string, mixed>
     */
    public function classify(array $bookData): array
    {
        $result = $this->preview(
            (string) ($bookData['judul'] ?? ''),
            (string) ($bookData['abstrak'] ?? ''),
            (string) ($bookData['subyek'] ?? ''),
        );

        return [
            'klasifikasi_id' => $result['id'],
            'classification_score' => $result['confidence'],
            'classification_keywords' => $result['matched_keywords'],
            'classification_source' => 'auto',
        ];
    }

    /**
     * @return array{id: int|null, name: string, code: string, confidence: float, matched_keywords: array<int, string>, alternatives: array<int, array<string, mixed>>}
     */
    public function preview(string $title, string $abstract, string $subject = ''): array
    {
        $categories = KlasifikasiBuku::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        if ($categories->isEmpty()) {
            return [
                'id' => null,
                'name' => 'Belum terklasifikasi',
                'code' => '-',
                'confidence' => 0,
                'matched_keywords' => [],
                'alternatives' => [],
            ];
        }

        $fields = [
            ['text' => $this->normalize($title), 'weight' => 3.0],
            ['text' => $this->normalize($subject), 'weight' => 2.4],
            ['text' => $this->normalize($abstract), 'weight' => 1.0],
        ];

        $ranked = $categories->map(function (KlasifikasiBuku $category) use ($fields): array {
            $score = 0.0;
            $matches = [];

            foreach ($category->keywords ?? [] as $keyword) {
                $normalizedKeyword = $this->normalize((string) $keyword);

                if ($normalizedKeyword === '') {
                    continue;
                }

                $keywordScore = 0.0;
                foreach ($fields as $field) {
                    $occurrences = min(substr_count($field['text'], $normalizedKeyword), 3);
                    if ($occurrences > 0) {
                        $phraseBoost = str_contains(trim($normalizedKeyword), ' ') ? 1.45 : 1.0;
                        $keywordScore += $occurrences * $field['weight'] * $phraseBoost;
                    }
                }

                if ($keywordScore > 0) {
                    $score += $keywordScore;
                    $matches[(string) $keyword] = $keywordScore;
                }
            }

            arsort($matches);

            return [
                'category' => $category,
                'score' => round($score, 2),
                'matches' => array_slice(array_keys($matches), 0, 8),
            ];
        })->sortByDesc('score')->values();

        $winner = $ranked->first();
        if (! $winner || $winner['score'] <= 0) {
            $general = $categories->firstWhere('kode', 'UMUM') ?? $categories->first();

            return [
                'id' => $general->getKey(),
                'name' => $general->nama,
                'code' => $general->kode,
                'confidence' => 20,
                'matched_keywords' => [],
                'alternatives' => [],
            ];
        }

        $positiveTotal = max((float) $ranked->sum('score'), 1.0);
        $confidence = min(99, max(25, round(($winner['score'] / ($positiveTotal + 1.5)) * 100, 2)));

        return [
            'id' => $winner['category']->getKey(),
            'name' => $winner['category']->nama,
            'code' => $winner['category']->kode,
            'confidence' => $confidence,
            'matched_keywords' => $winner['matches'],
            'alternatives' => $this->alternatives($ranked),
        ];
    }

    private function normalize(string $text): string
    {
        $normalized = Str::lower(Str::ascii(strip_tags($text)));
        $normalized = preg_replace('/[^a-z0-9]+/', ' ', $normalized) ?? '';

        return ' '.trim(preg_replace('/\s+/', ' ', $normalized) ?? '').' ';
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $ranked
     * @return array<int, array<string, mixed>>
     */
    private function alternatives(Collection $ranked): array
    {
        return $ranked
            ->filter(fn (array $item): bool => $item['score'] > 0)
            ->take(3)
            ->map(fn (array $item): array => [
                'id' => $item['category']->getKey(),
                'name' => $item['category']->nama,
                'code' => $item['category']->kode,
                'score' => $item['score'],
            ])
            ->values()
            ->all();
    }
}
