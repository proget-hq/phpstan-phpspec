<?php
declare(strict_types=1);

namespace Proget\Tests;


class Baz
{
    /**
     * @var bool
     */
    private $enabled = false;

    /**
     * @var string[]
     */
    private $items = [];

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

    public function addItem(string $item): void
    {
        $this->items[] = $item;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
