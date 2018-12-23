<?php

declare(strict_types=1);

namespace spec\PhpSpec\Process\Shutdown;

use PhpSpec\Formatter\FatalPresenter;
use PhpSpec\Message\CurrentExampleTracker;
use PhpSpec\ObjectBehavior;

class UpdateConsoleActionSpec extends ObjectBehavior
{
    public function let(FatalPresenter $currentExampleWriter)
    {
        $currentExample = new CurrentExampleTracker();
        $this->beConstructedWith($currentExample, $currentExampleWriter);
    }

    public function it_should_update_the_console(FatalPresenter $currentExampleWriter)
    {
        $currentExample = new CurrentExampleTracker();
        $error = ['type' => 1, 'message' => 'Hello'];
        $currentExample->getCurrentExample('Hello');
        $currentExampleWriter->displayFatal($currentExample, $error)->shouldBeCalled();
        $this->runAction($error);
    }
}
