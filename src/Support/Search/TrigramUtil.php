<?php

namespace BondarDe\Lox\Support\Search;

use TeamTNT\TNTSearch\Engines\SqliteEngine;
use TeamTNT\TNTSearch\Indexer\TNTIndexer;

class TrigramUtil
{
    public static function make(?string $s): ?string
    {
        if (!$s) {
            return null;
        }

        $engine = new SqliteEngine();
        $tnt = new TNTIndexer($engine);

        return $tnt->buildTrigrams($s);
    }
}
