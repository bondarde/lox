<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Data;

use Closure;
use Cron\CronExpression;
use Illuminate\Console\Application;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Support\Carbon;
use ReflectionClass;
use ReflectionFunction;

readonly class ScheduleEvent
{
    public function __construct(
        public string $type,
        public string $command,
        public string $description,
        public string $expression,
        public string $timezone,
        public Carbon $previousRun,
        public Carbon $nextRun,
        public string $output,
    ) {
        //
    }

    public static function from($event): self
    {
        [$type, $command, $description] = self::toCommand($event);

        return new self(
            type: $type,
            command: $command,
            description: $description,
            expression: $event->expression,
            timezone: $event->timezone,
            previousRun: self::toPreviousRunDate($event->expression),
            nextRun: self::toNextRunDate($event->expression),
            output: $event->output,
        );
    }

    public static function toCommand(mixed $event): array
    {
        $description = $event->description ?? '—';

        if ($event instanceof CallbackEvent) {
            if (class_exists($description)) {
                return [
                    'Class',
                    $description,
                    '',
                ];
            }

            return [
                'Closure',
                self::toClosureLocation($event),
                $description,
            ];
        }

        return [
            'PHP',
            self::cleanPhpCall($event->command),
            $description,
        ];
    }

    private static function toPreviousRunDate(string $expression): Carbon
    {
        $cronExpression = new CronExpression($expression);

        return Carbon::instance($cronExpression->getPreviousRunDate());
    }

    private static function toNextRunDate(string $expression): Carbon
    {
        $cronExpression = new CronExpression($expression);

        return Carbon::instance($cronExpression->getNextRunDate());
    }

    private static function toClosureLocation(CallbackEvent $event): string
    {
        $callback = tap((new ReflectionClass($event))->getProperty('callback'))
            ->setAccessible(true)
            ->getValue($event);

        if ($callback instanceof Closure) {
            $function = new ReflectionFunction($callback);

            return sprintf(
                '%s:%s',
                $function->getFileName(),
                $function->getStartLine(),
            );
        }

        if (is_string($callback)) {
            return $callback;
        }

        if (is_array($callback)) {
            $className = is_string($callback[0]) ? $callback[0] : $callback[0]::class;

            return sprintf('%s::%s', $className, $callback[1]);
        }

        return sprintf('%s::__invoke', $callback::class);
    }

    private static function cleanPhpCall(string $command): string
    {
        $phpBinary = Application::phpBinary();
        $artisanBinary = Application::artisanBinary();

        return str_replace([$phpBinary, $artisanBinary], [
            'php',
            preg_replace("#['\"]#", '', $artisanBinary),
        ], $command);
    }
}
