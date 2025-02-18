<?php

use BondarDe\Lox\Models\CmsPage;

?>
<div class="mb-3">
    @foreach($children as $child)
        <div
            @class([
                'mb-1 relative',
                'opacity-50' => !$child->{CmsPage::FIELD_IS_PUBLIC},
            ])
        >
            <input
                class="hidden peer"
                type="checkbox"
                id="page-{{ $child->{CmsPage::FIELD_ID} }}"
                checked
            />

            @if($child->{CmsPage::REL_CHILDREN}->isNotEmpty())
                <label
                    class="absolute -left-3 cursor-pointer peer-checked:rotate-90"
                    for="page-{{ $child->{CmsPage::FIELD_ID} }}"
                >
                    ▸
                </label>
            @endif

            <a
                class="hover:underline"
                href="{{ route('filament.admin.resources.cms-pages.view', $child) }}"
            >
                {{ $child->{CmsPage::FIELD_PAGE_TITLE} }}
            </a>

            @if($child->{CmsPage::REL_CHILDREN}->isNotEmpty())
                <div
                    class="pl-6 mt-1 hidden peer-checked:block"
                >
                    @include('lox::admin.cms._children', [
                        'children' => $child->{CmsPage::REL_CHILDREN},
                    ])
                </div>
            @endif
        </div>

    @endforeach
</div>
