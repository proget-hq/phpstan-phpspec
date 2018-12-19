<?php

declare(strict_types=1);

namespace Proget\Tests\PHPStan\PhpSpec;

final class Bar
{
    /**
     * @var Foo
     */
    private $foo;

    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }

    public function foo(): string
    {
        if ($this->foo->foo() === 'shouldThrow') {
            throw new \RuntimeException();
        }

        return $this->foo->foo();
    }
}
