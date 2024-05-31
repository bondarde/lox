<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Cms\Assistant;

use BondarDe\Lox\Constants\ValidationRules;
use BondarDe\Lox\Models\CmsAssistantTask;
use BondarDe\Lox\Repositories\CmsAssistantTaskRepository;
use Illuminate\Http\Request;

class AdminCmsAssistantStoreController
{
    public function __invoke(
        Request                    $request,
        CmsAssistantTaskRepository $cmsAssistantTaskRepository,
    )
    {
        $attributes = $request->validate([
            CmsAssistantTask::FIELD_TASK => [
                ValidationRules::OPTIONAL,
            ],
            CmsAssistantTask::FIELD_TOPIC => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],
            CmsAssistantTask::FIELD_LOCALE => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
                ValidationRules::min(2),
                ValidationRules::max(5),
            ],
        ]);

        $cmsAssistantTaskRepository->create($attributes);

        return to_route('admin.cms.assistant.index')
            ->with('success-message', __('Task has been created.'));
    }
}
