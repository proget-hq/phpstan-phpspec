<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Registry;

final class CustomMatchersRegistry
{
    /**
     * @var string[][]
     */
    private static $matchers = [];

    public static function addMatcher(string $specClass, string $matcher): void
    {
        if (!isset(self::$matchers[$specClass])) {
            self::$matchers[$specClass] = [];
        }

        self::$matchers[$specClass][] = $matcher;
    }

    public static function hasMatcher(string $specClass, string $matcher): bool
    {
        return isset(self::$matchers[$specClass]) && \in_array($matcher, self::$matchers[$specClass], true);
    }
}
