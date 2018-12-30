<?php
declare(strict_types=1);

namespace Proget\Tests;


class Baz
{
    /**
     * @var bool
     */
    private $enabled = false;

    public function someInt(): int
    {
        return 10;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
