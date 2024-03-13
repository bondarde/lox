<?php

use BondarDe\Lox\Models\CmsPage;

?>
<div>
    <ul>
        @foreach($children as $child)
            <li @class([
                'opacity-65' => !$child->{CmsPage::FIELD_IS_PUBLIC},
            ])>
                <a
                    class="hover:underline"
                    href="{{ route('admin.cms.pages.show', $child) }}"
                >
                    {{ $child->{CmsPage::FIELD_PAGE_TITLE} }}
                </a>
            </li>

            @if($child->{CmsPage::PROPERTY_CHILDREN}->isNotEmpty())
                <li class="pl-8 mb-2">
                    @include('lox::admin.cms._children', [
                        'children' => $child->{CmsPage::PROPERTY_CHILDREN},
                    ])
                </li>
            @endif
        @endforeach
    </ul>
</div>
