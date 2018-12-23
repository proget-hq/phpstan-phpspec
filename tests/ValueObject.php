<?php

declare(strict_types=1);

namespace Proget\Tests\PHPStan\PhpSpec;

final class ValueObject
{
    /**
     * @var string
     */
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function string(): string
    {
        return $this->string;
    }

    public function copy(): self
    {
        return new self($this->string);
    }
}
