<?php

namespace BondarDe\Lox\Constants;

enum DashboardItemColors: string
{
    case Default = 'bg-white dark:bg-gray-900 dark:hover:bg-gray-800';
    case Green = 'bg-green-50 hover:bg-green-100 text-green-800 dark:bg-green-900 dark:hover:bg-green-800 dark:text-green-200 dark:hover:text-green-100';
    case Yellow = 'bg-yellow-50 hover:bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:hover:bg-yellow-800 dark:text-yellow-200 dark:hover:text-yellow-100';
    case Red = 'bg-red-100 hover:bg-red-200 text-red-800 dark:bg-red-900 dark:hover:bg-red-800 dark:text-red-200 dark:hover:text-red-100';
}
