<?php

declare(strict_types=1);

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;

use PhpSpec\Event\ExampleEvent as Example;
use PhpSpec\Loader\Suite;

class SuiteEventSpec extends ObjectBehavior
{
    public function let(Suite $suite)
    {
        $this->beConstructedWith($suite, 10, Example::FAILED);
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

    public function it_provides_a_link_to_time()
    {
        $this->getTime()->shouldReturn(10.0);
    }

    public function it_provides_a_link_to_result()
    {
        $this->getResult()->shouldReturn(Example::FAILED);
    }

    public function it_defaults_to_saying_suite_is_not_worth_rerunning()
    {
        $this->isWorthRerunning()->shouldReturn(false);
    }

    public function it_can_be_told_that_the_suite_is_worth_rerunning()
    {
        $this->markAsWorthRerunning();
        $this->isWorthRerunning()->shouldReturn(true);
    }

    public function it_can_be_told_that_the_suite_is_no_longer_worth_rerunning()
    {
        $this->markAsWorthRerunning();
        $this->markAsNotWorthRerunning();

        $this->isWorthRerunning()->shouldReturn(false);
    }

    public function it_initializes_a_default_result(Suite $suite)
    {
        $this->beConstructedWith($suite);

        $this->getResult()->shouldReturn(Example::PASSED);
    }

    public function it_initializes_a_default_time(Suite $suite)
    {
        $this->beConstructedWith($suite);

        $this->getTime()->shouldReturn((double) 0.0);
    }
}
