<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Models\CmsAssistantTask;
use Illuminate\Database\Eloquent\Collection;

class CmsAssistantTaskRepository extends ModelRepository
{
    public function model(): string
    {
        return CmsAssistantTask::class;
    }

    public function tasksWaitingForExecution(
        int $limit = 1,
    ): Collection
    {
        return $this->query()
            ->whereNull(CmsAssistantTask::FIELD_EXECUTION_STARTED_AT)
            ->limit($limit)
            ->get();
    }
}
