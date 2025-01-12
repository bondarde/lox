<?php

return [
    'tntsearch' => [
        'storage' => storage_path(env('TNTSEARCH_STORAGE', 'tntsearch')),
        'fuzziness' => env('TNTSEARCH_FUZZINESS', true),
        'fuzzy' => [
            'prefix_length' => env('TNTSEARCH_FUZZY_PREFIX_LENGTH', 2),
            'max_expansions' => env('TNTSEARCH_FUZZY_MAX_EXPANSIONS', 50),
            'distance' => env('TNTSEARCH_FUZZY_DISTANCE', 2),
            'no_limit' => env('TNTSEARCH_FUZZY_NO_LIMIT', true),
        ],
        'asYouType' => env('TNTSEARCH_AS_YOU_TYPE', false),
        'searchBoolean' => env('TNTSEARCH_BOOLEAN', false),
        'maxDocs' => env('TNTSEARCH_MAX_DOCS', 500),
    ],
];
