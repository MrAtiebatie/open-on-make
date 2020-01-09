<?php

namespace OpenOnMake;

use App;
use Reflection;
use ReflectionClass;

class Check
{
    public static function envNotProduction() : bool
    {
        return config('app.env') !== 'production';
    }

    public static function executedCommandWasMakeCommand(string $command) : bool
    {
        return str_contains($command, 'make:');
    }

    public static function notCommandHelp(bool $help = false) : bool
    {
        return $help !== true;
    }

    public static function isSubClassOfGeneratorCommand(ReflectionClass $reflection) : bool
    {
        return $reflection->getParentClass()->getName() === \Illuminate\Console\GeneratorCommand::class;
    }

    public static function isViewCommand($command) : bool
    {
        return str_replace('make:', '', $command) === 'view';
    }

    /** This is because making a Model is only command you can generate other classes */
    public static function isMakeModelCommand(string $command) : bool
    {
        return str_contains($command, ':model');
    }

    public static function commandIsOpenable($command, $help = false) : bool
    {
        return Check::envNotProduction() &&
            Check::executedCommandWasMakeCommand($command) &&
            Check::notCommandHelp($help);
    }
}