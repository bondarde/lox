<?php

namespace BondarDe\Lox\Constants\Acl;

enum Permission: string
{
    case ViewModelMetaData = 'view model meta data';
    case ViewHiddenCmsPages = 'view hidden cms pages';
}
