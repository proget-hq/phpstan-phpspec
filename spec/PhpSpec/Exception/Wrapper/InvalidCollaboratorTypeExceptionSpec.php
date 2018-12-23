<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception\Wrapper;

use PhpSpec\ObjectBehavior;

class InvalidCollaboratorTypeExceptionSpec extends ObjectBehavior
{
    public function let(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $function)
    {
        $function->getName()->willReturn('bar');
        $this->beConstructedWith($parameter, $function);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpSpec\Exception\Wrapper\InvalidCollaboratorTypeException');
        $this->shouldHaveType('PhpSpec\Exception\Wrapper\CollaboratorException');
    }

    public function it_generates_correct_message_based_on_function_and_parameter(
        \ReflectionParameter $parameter,
        \ReflectionMethod $function,
        \ReflectionClass $class
    ) {
        $parameter->getPosition()->willReturn(2);
        $function->getDeclaringClass()->willReturn($class);
        $class->getName()->willReturn('Acme\Foo');
        $function->getName()->willReturn('bar');

        $this->getMessage()->shouldStartWith('Collaborator must be an object: argument 2 defined in Acme\Foo::bar.');
    }

    public function it_sets_cause(\ReflectionFunction $function)
    {
        $this->getCause()->shouldReturn($function);
    }
}
