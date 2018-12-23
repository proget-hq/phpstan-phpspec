<?php

declare(strict_types=1);

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;

use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Suite;

use Exception;

class ExampleEventSpec extends ObjectBehavior
{
    public function let(Suite $suite, SpecificationNode $specification, ExampleNode $example, Exception $exception)
    {
        $this->beConstructedWith($example, 10, $this->FAILED, $exception);

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

    public function it_provides_a_link_to_time()
    {
        $this->getTime()->shouldReturn((double) 10.0);
    }

    public function it_provides_a_link_to_result()
    {
        $this->getResult()->shouldReturn($this->FAILED);
    }

    public function it_provides_a_link_to_exception($exception)
    {
        $this->getException()->shouldReturn($exception);
    }

    public function it_initializes_a_default_result(ExampleNode $example)
    {
        $this->beConstructedWith($example);

        $this->getResult()->shouldReturn($this->PASSED);
    }

    public function it_initializes_a_default_time(ExampleNode $example)
    {
        $this->beConstructedWith($example);

        $this->getTime()->shouldReturn((double) 0.0);
    }
}
