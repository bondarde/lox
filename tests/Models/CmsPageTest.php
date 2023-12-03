<?php

namespace Tests\Models;

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsRedirect;
use BondarDe\Lox\Repositories\CmsRedirectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CmsPageTest extends TestCase
{
    use RefreshDatabase;

    public function testSlugGeneration()
    {
        $page = CmsPage::query()->create([
            CmsPage::FIELD_PAGE_TITLE => 'Test Page',
            CmsPage::FIELD_IS_PUBLIC => false,
            CmsPage::FIELD_IS_INDEX => false,
            CmsPage::FIELD_IS_FOLLOW => false,
        ]);

        self::assertEquals('test-page', $page->{CmsPage::FIELD_SLUG});
    }

    public function testPathChange()
    {
        // We create "Test Page" (path: "test-page") and its subpage "Test Subpage" (path: "test-page/test-subpage")
        // After changing slug "test-page" to "first-page", it's expected to have page URLs:
        // - first-page
        // - first-page/test-subpage
        // Two redirects must have been created:
        // - test-page -> first-page
        // - test-page/test-subpage -> first-page/test-subpage

        $page = CmsPage::query()->create([
            CmsPage::FIELD_PAGE_TITLE => 'Test Page',
            CmsPage::FIELD_IS_PUBLIC => true,
            CmsPage::FIELD_IS_INDEX => true,
            CmsPage::FIELD_IS_FOLLOW => true,
        ]);
        $subpage = CmsPage::query()->create([
            CmsPage::FIELD_PARENT_ID => $page->{CmsPage::FIELD_ID},
            CmsPage::FIELD_PAGE_TITLE => 'Test Subpage',
            CmsPage::FIELD_IS_PUBLIC => true,
            CmsPage::FIELD_IS_INDEX => true,
            CmsPage::FIELD_IS_FOLLOW => true,
        ]);

        self::assertEquals('test-page', $page->{CmsPage::FIELD_PATH});
        self::assertEquals('test-page/test-subpage', $subpage->{CmsPage::FIELD_PATH});

        $page->update([
            CmsPage::FIELD_SLUG => 'first-page',
        ]);
        $subpage->refresh();

        self::assertEquals('first-page/test-subpage', $subpage->{CmsPage::FIELD_PATH});

        /** @var Collection $redirects */
        $redirects = CmsRedirect::query()->get();

        /** @var CmsRedirectRepository $cmsRedirectRepository */
        $cmsRedirectRepository = app(CmsRedirectRepository::class);

        self::assertCount(2, $redirects);

        $redirect1 = $cmsRedirectRepository->getByPath('test-page');
        $redirect2 = $cmsRedirectRepository->getByPath('test-page/test-subpage');

        self::assertEquals('first-page', $redirect1->{CmsRedirect::FIELD_TARGET});
        self::assertEquals('first-page/test-subpage', $redirect2->{CmsRedirect::FIELD_TARGET});
    }

    public function testParentChange()
    {
        $page1 = CmsPage::query()->create([
            CmsPage::FIELD_PAGE_TITLE => 'Page 1',
            CmsPage::FIELD_IS_PUBLIC => true,
            CmsPage::FIELD_IS_INDEX => true,
            CmsPage::FIELD_IS_FOLLOW => true,
        ]);
        $page2 = CmsPage::query()->create([
            CmsPage::FIELD_PAGE_TITLE => 'Page 2',
            CmsPage::FIELD_IS_PUBLIC => true,
            CmsPage::FIELD_IS_INDEX => true,
            CmsPage::FIELD_IS_FOLLOW => true,
        ]);

        self::assertEquals('page-2', $page2->{CmsPage::FIELD_PATH});

        $page2->update([
            CmsPage::FIELD_PARENT_ID => $page1->{CmsPage::FIELD_ID},
        ]);

        self::assertEquals('page-1/page-2', $page2->{CmsPage::FIELD_PATH});

        $page2->update([
            CmsPage::FIELD_PARENT_ID => null,
        ]);

        self::assertEquals('page-2', $page2->{CmsPage::FIELD_PATH});
    }
}
