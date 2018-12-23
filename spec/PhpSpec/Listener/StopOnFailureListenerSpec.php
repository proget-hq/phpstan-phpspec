<?php

declare(strict_types=1);

namespace spec\PhpSpec\Listener;

use PhpSpec\ObjectBehavior;

use PhpSpec\Event\ExampleEvent;
use PhpSpec\Console\ConsoleIO;

class StopOnFailureListenerSpec extends ObjectBehavior
{
    public function let(ConsoleIO $io)
    {
        $io->isStopOnFailureEnabled()->willReturn(false);
        $this->beConstructedWith($io);
    }

    public function it_is_an_event_subscriber()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    public function it_does_not_throw_any_exception_when_example_succeeds(ExampleEvent $event)
    {
        $event->getResult()->willReturn(ExampleEvent::PASSED);

        $this->afterExample($event);
    }

    public function it_does_not_throw_any_exception_for_unimplemented_examples(ExampleEvent $event)
    {
        $event->getResult()->willReturn(ExampleEvent::PENDING);

        $this->afterExample($event);
    }

    public function it_throws_an_exception_when_an_example_fails_and_option_is_set(ExampleEvent $event, $io)
    {
        $io->isStopOnFailureEnabled()->willReturn(true);
        $event->getResult()->willReturn(ExampleEvent::FAILED);

        $this->shouldThrow('\PhpSpec\Exception\Example\StopOnFailureException')->duringAfterExample($event);
    }

    public function it_does_not_throw_an_exception_when_an_example_fails_and_option_is_not_set(ExampleEvent $event)
    {
        $event->getResult()->willReturn(ExampleEvent::FAILED);

        $this->afterExample($event);
    }

    public function it_throws_an_exception_when_an_example_breaks_and_option_is_set(ExampleEvent $event, $io)
    {
        $io->isStopOnFailureEnabled()->willReturn(true);
        $event->getResult()->willReturn(ExampleEvent::BROKEN);

        $this->shouldThrow('\PhpSpec\Exception\Example\StopOnFailureException')->duringAfterExample($event);
    }

    public function it_does_not_throw_an_exception_when_an_example_breaks_and_option_is_not_set(ExampleEvent $event)
    {
        $event->getResult()->willReturn(ExampleEvent::BROKEN);

        $this->afterExample($event);
    }
}
