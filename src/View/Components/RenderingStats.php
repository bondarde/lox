<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RenderingStats extends Component
{
    public int $renderingTimeMs;
    public int $dbQueriesTimeMs;
    public int $dbQueriesCount;
    public int $memoryPeakUsageBytes;

    public function __construct()
    {
        global $dbQueriesCount;
        global $dbQueriesTimeMs;

        $this->renderingTimeMs = (int)(1000 * (microtime(true) - LARAVEL_START));
        $this->dbQueriesTimeMs = (int)$dbQueriesTimeMs ?? -1;
        $this->dbQueriesCount = $dbQueriesCount ?? -1;
        $this->memoryPeakUsageBytes = memory_get_peak_usage(true);
    }

    public function render(): View
    {
        return view('lox::rendering-stats');
    }
}
