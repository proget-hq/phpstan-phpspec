<?php

declare(strict_types=1);

namespace spec\PhpSpec\Process\Shutdown;

use PhpSpec\ObjectBehavior;
use PhpSpec\Process\Shutdown\ShutdownAction;

class ShutdownSpec extends ObjectBehavior
{
    public function it_has_type_shutdown()
    {
        $this->beAnInstanceOf('PhpSpec/Process/Shutdown/Shutdown');
    }

    public function it_runs_through_all_registered_actions(ShutdownAction $action)
    {
        $action->runAction(null)->shouldBeCalled();
        $this->registerAction($action);
        $this->runShutdown();
    }
}
