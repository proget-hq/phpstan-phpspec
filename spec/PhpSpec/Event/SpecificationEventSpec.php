<?php

declare(strict_types=1);

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;

use PhpSpec\Event\ExampleEvent as Example;
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Suite;

class SpecificationEventSpec extends ObjectBehavior
{
    public function let(Suite $suite, SpecificationNode $specification)
    {
        $this->beConstructedWith($specification, 10, Example::FAILED);

        $specification->getSuite()->willReturn($suite);
    }

    public function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\EventDispatcher\Event');
        $this->shouldBeAnInstanceOf('PhpSpec\Event\PhpSpecEvent');
    }

    public function it_provides_a_link_to_suite($suite)
    {
        $this->getSuite()->shouldReturn($suite);
    }

    public function it_provides_a_link_to_specification($specification)
    {
        $this->getSpecification()->shouldReturn($specification);
    }

    public function it_provides_a_link_to_time()
    {
        $this->getTime()->shouldReturn(10.0);
    }

    public function it_provides_a_link_to_result()
    {
        $this->getResult()->shouldReturn(Example::FAILED);
    }

    public function it_initializes_a_default_result(SpecificationNode $specification)
    {
        $this->beConstructedWith($specification);

        $this->getResult()->shouldReturn(Example::PASSED);
    }

    public function it_initializes_a_default_time(SpecificationNode $specification)
    {
        $this->beConstructedWith($specification);

        $this->getTime()->shouldReturn(0.0);
    }
}
