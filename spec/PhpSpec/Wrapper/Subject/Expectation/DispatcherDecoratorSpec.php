<?php

declare(strict_types=1);

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Wrapper\Subject\Expectation\Expectation;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\Matcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use PhpSpec\Event\ExpectationEvent;

class DispatcherDecoratorSpec extends ObjectBehavior
{
    public function let(Expectation $expectation, EventDispatcherInterface $dispatcher, Matcher $matcher, ExampleNode $example)
    {
        $this->beConstructedWith($expectation, $dispatcher, $matcher, $example);
    }

    public function it_implements_the_interface_of_the_decorated()
    {
        $this->shouldImplement('PhpSpec\Wrapper\Subject\Expectation\Expectation');
    }

    public function it_dispatches_before_and_after_events(EventDispatcherInterface $dispatcher)
    {
        $alias = 'be';
        $subject = new \stdClass();
        $arguments = [];

        $dispatcher->dispatch('beforeExpectation', Argument::type('PhpSpec\Event\ExpectationEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterExpectation', Argument::which('getResult', ExpectationEvent::PASSED))->shouldBeCalled();
        $this->match($alias, $subject, $arguments);
    }

    public function it_decorates_expectation_with_failed_event(Expectation $expectation, EventDispatcherInterface $dispatcher)
    {
        $alias = 'be';
        $subject = new \stdClass();
        $arguments = [];

        $expectation->match(Argument::cetera())->willThrow('PhpSpec\Exception\Example\FailureException');

        $dispatcher->dispatch('beforeExpectation', Argument::type('PhpSpec\Event\ExpectationEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterExpectation', Argument::which('getResult', ExpectationEvent::FAILED))->shouldBeCalled();

        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')->duringMatch($alias, $subject, $arguments);
    }

    public function it_decorates_expectation_with_broken_event(Expectation $expectation, EventDispatcherInterface $dispatcher)
    {
        $alias = 'be';
        $subject = new \stdClass();
        $arguments = [];

        $expectation->match(Argument::cetera())->willThrow('\RuntimeException');

        $dispatcher->dispatch('beforeExpectation', Argument::type('PhpSpec\Event\ExpectationEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterExpectation', Argument::which('getResult', ExpectationEvent::BROKEN))->shouldBeCalled();

        $this->shouldThrow('\RuntimeException')->duringMatch($alias, $subject, $arguments);
    }
}
