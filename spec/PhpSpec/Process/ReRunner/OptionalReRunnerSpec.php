<?php

declare(strict_types=1);

namespace spec\PhpSpec\Process\ReRunner;

use PhpSpec\Console\ConsoleIO;
use PhpSpec\ObjectBehavior;
use PhpSpec\Process\ReRunner;

class OptionalReRunnerSpec extends ObjectBehavior
{
    public function let(ConsoleIO $io, ReRunner $decoratedReRunner)
    {
        $this->beconstructedWith($decoratedReRunner, $io);
    }

    public function it_reruns_the_suite_if_it_is_enabled_in_the_config(ConsoleIO $io, ReRunner $decoratedReRunner)
    {
        $io->isRerunEnabled()->willReturn(true);

        $this->reRunSuite();

        $decoratedReRunner->reRunSuite()->shouldHaveBeenCalled();
    }

    public function it_does_not_rerun_the_suite_if_it_is_disabled_in_the_config(ConsoleIO $io, ReRunner $decoratedReRunner)
    {
        $io->isRerunEnabled()->willReturn(false);

        $this->reRunSuite();

        $decoratedReRunner->reRunSuite()->shouldNotHaveBeenCalled();
    }
}
