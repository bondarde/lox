<?php

namespace BondarDe\Lox\Console\Commands\Cms;

use BondarDe\Lox\Models\CmsAssistantTask;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Repositories\CmsAssistantTaskRepository;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Utils\Html\DOM;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;

class ExecuteCmsTasksCommand extends Command
{
    protected $signature = 'cms:execute-tasks';
    protected $description = 'Executes planed CMS tasks';

    public function __construct(
        private readonly CmsAssistantTaskRepository $cmsAssistantTaskRepository,
        private readonly CmsPageRepository $cmsPageRepository,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $tasks = $this->cmsAssistantTaskRepository->tasksWaitingForExecution();

        $tasks->each(
            fn (CmsAssistantTask $cmsAssistantTask) => $this->executeTask($cmsAssistantTask),
        );

        $this->output->success('Done.');
    }

    private function executeTask(CmsAssistantTask $cmsAssistantTask): void
    {
        $this->cmsAssistantTaskRepository->update($cmsAssistantTask, [
            CmsAssistantTask::FIELD_EXECUTION_STARTED_AT => now(),
        ]);

        $task = $cmsAssistantTask->{CmsAssistantTask::FIELD_TASK};
        $topic = $cmsAssistantTask->{CmsAssistantTask::FIELD_TOPIC};
        $locale = $cmsAssistantTask->{CmsAssistantTask::FIELD_LOCALE};

        $prompt = $task . ' ' . $topic;

        $request = [
            'model' => config('lox.cms.assistant.model'),
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ];

        /** @var CreateResponse $res */
        $res = OpenAI::chat()->create($request);
        $content = Str::of($res->choices[0]->message->content)
            ->explode("\n")
            ->filter()
            ->map(fn (string $line) => DOM::p($line))
            ->join('');

        /** @var CmsPage $cmsPage */
        $cmsPage = $this->cmsPageRepository->create([
            CmsPage::FIELD_PAGE_TITLE => $topic,
            CmsPage::FIELD_SLUG => Str::slug($topic, language: $locale),
            CmsPage::FIELD_IS_PUBLIC => false,
            CmsPage::FIELD_IS_INDEX => false,
            CmsPage::FIELD_IS_FOLLOW => false,
        ]);

        $cmsPage
            ->setTranslation(CmsPage::FIELD_CONTENT, $locale, $content)
            ->save();

        $this->cmsAssistantTaskRepository->update($cmsAssistantTask, [
            CmsAssistantTask::FIELD_EXECUTION_FINISHED_AT => now(),
        ]);
    }
}
