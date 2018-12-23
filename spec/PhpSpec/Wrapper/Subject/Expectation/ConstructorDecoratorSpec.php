<?php

declare(strict_types=1);

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use PhpSpec\Wrapper\Subject\WrappedObject;

use PhpSpec\Wrapper\Subject\Expectation\Expectation;

class ConstructorDecoratorSpec extends ObjectBehavior
{
    public function let(Expectation $expectation)
    {
        $this->beConstructedWith($expectation);
    }

    public function it_rethrows_php_errors_as_phpspec_error_exceptions(Subject $subject, WrappedObject $wrapped)
    {
        $subject->callOnWrappedObject('getWrappedObject', [])->willThrow('PhpSpec\Exception\Example\ErrorException');
        $this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->duringMatch('be', $subject, [], $wrapped);
    }

    public function it_rethrows_fracture_errors_as_phpspec_error_exceptions(Subject $subject, WrappedObject $wrapped)
    {
        $subject->__call('getWrappedObject', [])->willThrow('PhpSpec\Exception\Fracture\FractureException');
        $this->shouldThrow('PhpSpec\Exception\Fracture\FractureException')->duringMatch('be', $subject, [], $wrapped);
    }

    public function it_ignores_any_other_exception(Subject $subject, WrappedObject $wrapped)
    {
        $subject->callOnWrappedObject('getWrappedObject', [])->willThrow('\Exception');
        $wrapped->getClassName()->willReturn('\stdClass');
        $this->shouldNotThrow('\Exception')->duringMatch('be', $subject, [], $wrapped);
    }
}
