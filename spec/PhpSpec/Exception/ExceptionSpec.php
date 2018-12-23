<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception;

use PhpSpec\ObjectBehavior;

use ReflectionMethod;

class ExceptionSpec extends ObjectBehavior
{
    public function it_extends_basic_exception()
    {
        $this->shouldBeAnInstanceOf('Exception');
    }

    public function it_could_have_a_cause(ReflectionMethod $cause)
    {
        $this->setCause($cause);
        $this->getCause()->shouldReturn($cause);
    }
}
