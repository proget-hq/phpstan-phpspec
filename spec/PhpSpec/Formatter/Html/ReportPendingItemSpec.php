<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Html;

use PhpSpec\ObjectBehavior;

use PhpSpec\Event\ExampleEvent;
use PhpSpec\Formatter\Html\Template as HtmlTemplate;
use PhpSpec\Formatter\Template;

class ReportPendingItemSpec extends ObjectBehavior
{
    const EVENT_TITLE = 'it works';

    public function let(Template $template, ExampleEvent $event)
    {
        $this->beConstructedWith($template, $event);
    }

    public function it_writes_a_pass_message_for_a_passing_example(Template $template, ExampleEvent $event)
    {
        $event->getTitle()->willReturn(self::EVENT_TITLE);
        $template->render(HtmlTemplate::DIR.'/Template/ReportPending.html', [
            'title' => self::EVENT_TITLE,
            'pendingExamplesCount' => 1
        ])->shouldBeCalled();
        $this->write();
    }
}
