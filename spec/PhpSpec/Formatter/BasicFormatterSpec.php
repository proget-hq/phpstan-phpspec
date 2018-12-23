<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter;

use PhpSpec\ObjectBehavior;

use PhpSpec\Formatter\BasicFormatter;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\IO\IO;
use PhpSpec\Listener\StatisticsCollector;

class BasicFormatterSpec extends ObjectBehavior
{
    public function let(Presenter $presenter, IO $io, StatisticsCollector $stats)
    {
        $this->beAnInstanceOf('spec\PhpSpec\Formatter\TestableBasicFormatter');
        $this->beConstructedWith($presenter, $io, $stats);
    }

    public function it_is_an_event_subscriber()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    public function it_returns_a_list_of_subscribed_events()
    {
        $this::getSubscribedEvents()->shouldBe(
            [
                'beforeSuite' => 'beforeSuite',
                'afterSuite' => 'afterSuite',
                'beforeExample' => 'beforeExample',
                'afterExample' => 'afterExample',
                'beforeSpecification' => 'beforeSpecification',
                'afterSpecification' => 'afterSpecification'
            ]
        );
    }
}

class TestableBasicFormatter extends BasicFormatter
{
}
