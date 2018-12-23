<?php

declare(strict_types=1);

namespace spec\PhpSpec\Process\Context;

use PhpSpec\ObjectBehavior;

class JsonExecutionContextSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('fromEnv', [['PHPSPEC_EXECUTION_CONTEXT' => '{"generated-types":[]}']]);
    }

    public function it_is_an_execution_context()
    {
        $this->shouldHaveType('PhpSpec\Process\Context\ExecutionContext');
    }

    public function it_contains_no_generated_classes_when_created()
    {
        $this->getGeneratedTypes()->shouldReturn([]);
    }

    public function it_remembers_what_classes_were_generated()
    {
        $this->addGeneratedType('PhpSpec\Foo');

        $this->getGeneratedTypes()->shouldReturn(['PhpSpec\Foo']);
    }

    public function it_can_be_serialized_as_env_array()
    {
        $this->addGeneratedType('PhpSpec\Foo');

        $this->asEnv()->shouldReturn(['PHPSPEC_EXECUTION_CONTEXT' => '{"generated-types":["PhpSpec\\\\Foo"]}']);
    }
}
