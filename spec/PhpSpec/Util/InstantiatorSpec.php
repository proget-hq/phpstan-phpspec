<?php

declare(strict_types=1);

namespace spec\PhpSpec\Util;

use PhpSpec\ObjectBehavior;

class InstantiatorSpec extends ObjectBehavior
{
    public function it_creates_an_instance()
    {
        $this->instantiate('spec\PhpSpec\Util\NoConstructor')
            ->shouldBeAnInstanceOf('spec\PhpSpec\Util\NoConstructor');
    }

    public function it_creates_an_instance_ignoring_constructor()
    {
        $this->instantiate('spec\PhpSpec\Util\WithConstructor')
            ->shouldBeAnInstanceOf('spec\PhpSpec\Util\WithConstructor');
    }

    public function it_creates_an_instance_with_properties()
    {
        $this->instantiate('spec\PhpSpec\Util\WithProperties')
            ->shouldBeAnInstanceOf('spec\PhpSpec\Util\WithProperties');
    }

    public function it_complains_if_class_does_not_exist()
    {
        $this->shouldThrow('PhpSpec\Exception\Fracture\ClassNotFoundException')
            ->duringInstantiate('NonExistingClass');
    }
}

class NoConstructor
{
}

class WithConstructor
{
    private $requiredArgument;

    public function __construct($requiredArgument)
    {
        $this->requiredArgument = $requiredArgument;
    }
}

class WithProperties
{
    private $foo;

    protected $bar;

    public $baz;
}
