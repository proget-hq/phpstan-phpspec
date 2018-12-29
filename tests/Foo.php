<?php
declare(strict_types=1);

namespace Proget\Tests;

class Foo
{
    /**
     * @var string
     */
    public $property;

    public function __construct()
    {
        $this->property = 'Lorem lipsum';
    }

    public function getIntFromBaz(Bar $bar): int
    {
        return $bar->baz->someInt();
    }
}
