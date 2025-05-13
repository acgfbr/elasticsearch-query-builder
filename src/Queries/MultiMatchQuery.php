<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class MultiMatchQuery implements Query
{
    public const TYPE_BEST_FIELDS = 'best_fields';
    public const TYPE_MOST_FIELDS = 'most_fields';
    public const TYPE_CROSS_FIELDS = 'cross_fields';
    public const TYPE_PHRASE = 'phrase';
    public const TYPE_PHRASE_PREFIX = 'phrase_prefix';
    public const TYPE_BOOL_PREFIX = 'bool_prefix';

    public static function create(
        string $query,
        array $fields,
        int | string | null $fuzziness = null,
        ?string $type = null,
        null | float $boost = null
    ): static {
        return new self($query, $fields, $fuzziness, $type, $boost);
    }

    public function __construct(
        protected string $query,
        protected array $fields,
        protected int | string | null $fuzziness = null,
        protected ?string $type = null,
        protected null | float $boost = null
    ) {
    }

    public function toArray(): array
    {
        $multiMatch = [
            'multi_match' => [
                'query' => $this->query,
                'fields' => $this->fields,
            ],
        ];

        if ($this->fuzziness) {
            $multiMatch['multi_match']['fuzziness'] = $this->fuzziness;
        }

        if ($this->type) {
            $multiMatch['multi_match']['type'] = $this->type;
        }

        if ($this->boost !== null) {
            $multiMatch['multi_match']['boost'] = $this->boost;
        }


        return $multiMatch;
    }
}
