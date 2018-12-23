<?php

declare(strict_types=1);

namespace spec\PhpSpec\CodeGenerator\Generator;

use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;

class ReturnConstantGeneratorSpec extends ObjectBehavior
{
    public function let(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem)
    {
        $this->beConstructedWith($io, $templates, $filesystem);
    }

    public function it_is_a_generator()
    {
        $this->shouldHaveType('PhpSpec\CodeGenerator\Generator\Generator');
    }

    public function it_supports_returnConstant_generation(Resource $resource)
    {
        $this->supports($resource, 'returnConstant', [])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else(Resource $resource)
    {
        $this->supports($resource, 'anything_else', [])->shouldReturn(false);
    }

    public function its_priority_is_0()
    {
        $this->getPriority()->shouldReturn(0);
    }
}
