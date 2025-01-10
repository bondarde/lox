<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsPageResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPageResource;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use BondarDe\Lox\Repositories\CmsTemplateVariableValueRepository;
use Filament\Actions\DeleteAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditCmsPage extends EditRecord
{
    use Translatable;

    protected static string $resource = CmsPageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (! isset($data[CmsPage::FIELD_PARENT_ID])) {
            $data[CmsPage::FIELD_PARENT_ID] = CmsPageResource::$defaultNoParentValue;
        }
        if (! isset($data[CmsPage::FIELD_CMS_TEMPLATE_ID])) {
            $data[CmsPage::FIELD_CMS_TEMPLATE_ID] = CmsPageResource::$defaultNoTemplateValue;
        }

        /** @var CmsPage $cmsPage */
        $cmsPage = $this->getRecord();

        $templateVariables = $cmsPage->{CmsPage::REL_TEMPLATE}?->{CmsTemplate::REL_TEMPLATE_VARIABLES} ?? [];

        foreach ($templateVariables as $tv) {
            $dataFieldName = CmsPageResource::$tvFieldNamePrefix . $tv->{CmsTemplateVariable::FIELD_ID};
            $value = $cmsPage->cmsTemplateVariableValue($tv);
            $data[$dataFieldName] = $value;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data[CmsPage::FIELD_PARENT_ID] === CmsPageResource::$defaultNoParentValue) {
            $data[CmsPage::FIELD_PARENT_ID] = null;
        }
        if ($data[CmsPage::FIELD_CMS_TEMPLATE_ID] === CmsPageResource::$defaultNoTemplateValue) {
            $data[CmsPage::FIELD_CMS_TEMPLATE_ID] = null;
        }

        return $data;
    }

    public function afterSave(): void
    {
        $data = $this->form->validate()['data'];
        /** @var CmsPage $cmsPage */
        $cmsPage = $this->getRecord();

        $cmsTemplateVariableValueRepository = app(CmsTemplateVariableValueRepository::class);

        $templateVariables = $cmsPage->{CmsPage::REL_TEMPLATE}?->{CmsTemplate::REL_TEMPLATE_VARIABLES} ?? [];

        foreach ($templateVariables as $tv) {
            $dataFieldName = CmsPageResource::$tvFieldNamePrefix . $tv->{CmsTemplateVariable::FIELD_ID};
            $value = $data[$dataFieldName] ?? null;

            if ($value === null) {
                continue;
            }

            $cmsTemplateVariableValueRepository->setValue(
                $cmsPage,
                $tv,
                $value,
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
