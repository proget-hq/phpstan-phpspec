<?php

declare(strict_types=1);

namespace Proget\Tests\PHPStan\PhpSpec;

class Foo
{
    /**
     * @var Baz
     */
    private $baz;

    public function __construct(Baz $baz)
    {
        $this->baz = $baz;
    }

    public function foo(): string
    {
        return '';
    }

    public function makeBaz(): int
    {
        return $this->baz->make();
    }

    public function makeValueObject(string $string): ValueObject
    {
        return new ValueObject($string);
    }
}
