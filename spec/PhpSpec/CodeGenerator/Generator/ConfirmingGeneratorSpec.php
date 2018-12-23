<?php

declare(strict_types=1);

namespace spec\PhpSpec\CodeGenerator\Generator;

use PhpSpec\CodeGenerator\Generator\Generator;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\ObjectBehavior;
use PhpSpec\Locator\Resource;

class ConfirmingGeneratorSpec extends ObjectBehavior
{
    public function let(ConsoleIO $io, Generator $generator)
    {
        $this->beConstructedWith($io, 'Question for {CLASSNAME}', $generator);
    }

    public function it_is_a_Generator()
    {
        $this->shouldHaveType('PhpSpec\CodeGenerator\Generator\Generator');
    }

    public function it_supports_the_same_generator_as_its_parent(Generator $generator, Resource $resource)
    {
        $generator->supports($resource, 'generation', [])->willReturn(true);

        $this->supports($resource, 'generation', [])->shouldReturn(true);
    }

    public function it_has_the_same_priority_as_its_parent(Generator $generator)
    {
        $generator->getPriority()->willReturn(1324);

        $this->getPriority()->shouldReturn(1324);
    }

    public function it_does_not_call_the_parent_generate_method_if_the_user_answers_no(Generator $generator, Resource $resource, ConsoleIO $io)
    {
        $resource->getSrcClassname()->willReturn('Namespace/Classname');

        $io->askConfirmation('Question for Namespace/Classname')->willReturn(false);

        $this->generate($resource, []);

        $generator->generate($resource, [])->shouldNotHaveBeenCalled();
    }

    public function it_calls_the_parent_generate_method_if_the_user_answers_yes(Generator $generator, Resource $resource, ConsoleIO $io)
    {
        $resource->getSrcClassname()->willReturn('Namespace/Classname');

        $io->askConfirmation('Question for Namespace/Classname')->willReturn(true);

        $this->generate($resource, []);

        $generator->generate($resource, [])->shouldHaveBeenCalled();
    }
}
