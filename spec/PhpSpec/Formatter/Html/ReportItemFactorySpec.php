<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Html;

use PhpSpec\ObjectBehavior;

use PhpSpec\Event\ExampleEvent;
use PhpSpec\Formatter\Template;
use PhpSpec\Formatter\Presenter\Presenter;

class ReportItemFactorySpec extends ObjectBehavior
{
    public function let(Template $template)
    {
        $this->beConstructedWith($template);
    }

    public function it_creates_a_ReportPassedItem(ExampleEvent $event, Presenter $presenter)
    {
        $event->getResult()->willReturn(ExampleEvent::PASSED);
        $this->create($event, $presenter)->shouldHaveType('PhpSpec\Formatter\Html\ReportPassedItem');
    }

    public function it_creates_a_ReportPendingItem(ExampleEvent $event, Presenter $presenter)
    {
        $event->getResult()->willReturn(ExampleEvent::PENDING);
        $this->create($event, $presenter)->shouldHaveType('PhpSpec\Formatter\Html\ReportPendingItem');
    }

    public function it_creates_a_ReportFailedItem(ExampleEvent $event, Presenter $presenter)
    {
        $event->getResult()->willReturn(ExampleEvent::FAILED);
        $this->create($event, $presenter)->shouldHaveType('PhpSpec\Formatter\Html\ReportFailedItem');
    }

    public function it_creates_a_ReportBrokenItem(ExampleEvent $event, Presenter $presenter)
    {
        $event->getResult()->willReturn(ExampleEvent::BROKEN);
        $this->create($event, $presenter)->shouldHaveType('PhpSpec\Formatter\Html\ReportFailedItem');
    }
}
