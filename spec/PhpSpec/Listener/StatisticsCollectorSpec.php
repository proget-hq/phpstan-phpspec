<?php

declare(strict_types=1);

namespace spec\PhpSpec\Listener;

use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SpecificationEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Suite;
use PhpSpec\ObjectBehavior;

class StatisticsCollectorSpec extends ObjectBehavior
{
    public function let(ExampleEvent $failingExample, ExampleEvent $passingExample)
    {
        $failingExample->getResult()->willReturn(ExampleEvent::FAILED);
        $passingExample->getResult()->willReturn(ExampleEvent::PASSED);
    }

    public function it_is_an_event_listener()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    public function it_listens_to_stats_generating_events()
    {
        $subscribedEvents = $this->getSubscribedEvents();

        $subscribedEvents->shouldHaveKey('afterExample');
        $subscribedEvents->shouldHaveKey('afterSpecification');
        $subscribedEvents->shouldHaveKey('beforeSuite');
    }

    public function it_knows_no_specs_have_run_initially()
    {
        $this->getTotalSpecs()->shouldReturn(0);
    }

    public function it_counts_how_many_specs_have_run(SpecificationEvent $specEvent1, SpecificationEvent $specEvent2)
    {
        $this->afterSpecification($specEvent1);
        $this->afterSpecification($specEvent2);

        $this->getTotalSpecs()->shouldReturn(2);
    }

    public function it_knows_no_examples_have_run_initially()
    {
        $this->getEventsCount()->shouldReturn(0);
    }

    public function it_counts_how_many_examples_have_run(ExampleEvent $failingExample, ExampleEvent $passingExample)
    {
        $this->afterExample($passingExample);
        $this->afterExample($failingExample);

        $this->getEventsCount()->shouldReturn(2);
    }

    public function it_logs_all_example_events(ExampleEvent $failingExample, ExampleEvent $passingExample)
    {
        $this->afterExample($passingExample);
        $this->afterExample($failingExample);

        $this->getAllEvents()->shouldReturn([
            $passingExample,
            $failingExample
        ]);
    }

    public function it_logs_all_example_events_by_type(ExampleEvent $failingExample, ExampleEvent $passingExample)
    {
        $this->afterExample($passingExample);
        $this->afterExample($failingExample);

        $this->getPassedEvents()->shouldReturn([$passingExample]);
    }

    public function it_counts_example_results_by_type(ExampleEvent $failingExample, ExampleEvent $passingExample)
    {
        $this->afterExample($passingExample);
        $this->afterExample($failingExample);

        $this->getCountsHash()->shouldReturn(
            [
                'passed' => 1,
                'pending' => 0,
                'skipped' => 0,
                'failed' => 1,
                'broken' => 0,
            ]
        );
    }

    public function it_returns_the_worst_result_as_the_global_result(ExampleEvent $failingExample, ExampleEvent $passingExample)
    {
        $this->afterExample($passingExample);
        $this->afterExample($failingExample);

        $this->getGlobalResult()->shouldReturn(ExampleEvent::FAILED);
    }

    public function it_records_how_many_specs_are_in_the_suite(SuiteEvent $suiteEvent, Suite $suite, SpecificationNode $spec)
    {
        $suiteEvent->getSuite()->willReturn($suite);
        $suite->getSpecifications()->willReturn([$spec]);

        $this->beforeSuite($suiteEvent);

        $this->getTotalSpecsCount()->shouldReturn(1);
    }
}
