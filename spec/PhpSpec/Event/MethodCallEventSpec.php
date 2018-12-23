<?php

declare(strict_types=1);

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;
use PhpSpec\Loader\Suite;
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Node\ExampleNode;

class MethodCallEventSpec extends ObjectBehavior
{
    public function let(Suite $suite, SpecificationNode $specification, ExampleNode $example, $subject)
    {
        $method = 'calledMethod';
        $arguments = ['methodArguments'];
        $returnValue = 'returned value';

        $this->beConstructedWith($example, $subject, $method, $arguments, $returnValue);

        $example->getSpecification()->willReturn($specification);
        $specification->getSuite()->willReturn($suite);
    }

    public function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\EventDispatcher\Event');
        $this->shouldBeAnInstanceOf('PhpSpec\Event\PhpSpecEvent');
    }

    public function it_provides_a_link_to_example($example)
    {
        $this->getExample()->shouldReturn($example);
    }

    public function it_provides_a_link_to_specification($specification)
    {
        $this->getSpecification()->shouldReturn($specification);
    }

    public function it_provides_a_link_to_suite($suite)
    {
        $this->getSuite()->shouldReturn($suite);
    }

    public function it_provides_a_link_to_subject($subject)
    {
        $this->getSubject()->shouldReturn($subject);
    }

    public function it_provides_a_link_to_method()
    {
        $this->getMethod()->shouldReturn('calledMethod');
    }

    public function it_provides_a_link_to_arguments()
    {
        $this->getArguments()->shouldReturn(['methodArguments']);
    }

    public function it_provides_a_link_to_return_value()
    {
        $this->getReturnValue()->shouldReturn('returned value');
    }
}
