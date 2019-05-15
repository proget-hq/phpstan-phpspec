<?php

declare(strict_types=1);

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;
use PhpSpec\Loader\Suite;
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\Matcher;
use Exception;

class ExpectationEventSpec extends ObjectBehavior
{
    public function let(
        Suite $suite,
        SpecificationNode $specification,
        ExampleNode $example,
        Matcher $matcher,
        $subject,
        Exception $exception
    ) {
        $method = 'calledMethod';
        $arguments = ['methodArguments'];

        $this->beConstructedWith($example, $matcher, $subject, $method, $arguments, $this->FAILED, $exception);

        $example->getSpecification()->willReturn($specification);
        $specification->getSuite()->willReturn($suite);
    }

    public function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\EventDispatcher\Event');
        $this->shouldBeAnInstanceOf('PhpSpec\Event\PhpSpecEvent');
    }

    public function it_provides_a_link_to_matcher($matcher)
    {
        $this->getMatcher()->shouldReturn($matcher);
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

    public function it_provides_a_link_to_result()
    {
        $this->getResult()->shouldReturn($this->FAILED);
    }

    public function it_provides_a_link_to_exception($exception)
    {
        $this->getException()->shouldReturn($exception);
    }

    public function it_initializes_a_default_result(ExampleNode $example, Matcher $matcher, $subject)
    {
        $method = 'calledMethod';
        $arguments = ['methodArguments'];

        $this->beConstructedWith($example, $matcher, $subject, $method, $arguments);

        $this->getResult()->shouldReturn($this->PASSED);
    }
}
