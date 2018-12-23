<?php

declare(strict_types=1);

namespace spec\PhpSpec\Process\Prerequisites;

use PhpSpec\ObjectBehavior;
use PhpSpec\Process\Context\ExecutionContext;

class SuitePrerequisitesSpec extends ObjectBehavior
{
    public function let(ExecutionContext $executionContext)
    {
        $this->beConstructedWith($executionContext);
    }

    public function it_does_nothing_when_types_exist(ExecutionContext $executionContext)
    {
        $executionContext->getGeneratedTypes()->willReturn(['stdClass']);

        $this->guardPrerequisites();
    }

    public function it_throws_execption_when_types_do_not_exist(ExecutionContext $executionContext)
    {
        $executionContext->getGeneratedTypes()->willReturn(['stdClassXXX']);

        $this->shouldThrow('PhpSpec\Process\Prerequisites\PrerequisiteFailedException')->duringGuardPrerequisites();
    }
}
