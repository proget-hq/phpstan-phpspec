<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Registry;

use Proget\PHPStan\PhpSpec\Exception\RuntimeException;

final class SpoofedCollaboratorRegistry
{
    private static $register = [];

    public static function setAlias(string $original, string $alias): void
    {
        if (isset(self::$register[$original])) {
            throw new RuntimeException(sprintf('Class %s already registered', $original));
        }

        self::$register[$original] = $alias;
    }

    public static function getAlias(string $original): string
    {
        if (!isset(self::$register[$original])) {
            throw new RuntimeException(sprintf('Class %s not found', $original));
        }

        return self::$register[$original];
    }
}
