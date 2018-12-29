<?php
declare(strict_types=1);

namespace Proget\Tests;


class Bar
{
    /**
     * @var Foo
     */
    private $foo;

    /**
     * @var Baz
     */
    public $baz;

    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
        $this->baz = new Baz();
    }

    public function getFooProperty(): string
    {
        return $this->foo->property;
    }

}
