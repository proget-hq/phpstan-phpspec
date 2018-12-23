<?php

declare(strict_types=1);

namespace spec\PhpSpec\CodeGenerator;

use PhpSpec\ObjectBehavior;

use PhpSpec\CodeGenerator\Generator\Generator;
use PhpSpec\Locator\Resource;

class GeneratorManagerSpec extends ObjectBehavior
{
    public function it_uses_registered_generators_to_generate_code(
        Generator $generator,
        Resource $resource
    ) {
        $generator->getPriority()->willReturn(0);
        $generator->supports($resource, 'specification', [])->willReturn(true);
        $generator->generate($resource, [])->shouldBeCalled();

        $this->registerGenerator($generator);
        $this->generate($resource, 'specification');
    }

    public function it_chooses_generator_by_priority(
        Generator $generator1,
        Generator $generator2,
        Resource $resource
    ) {
        $generator1->supports($resource, 'class', ['class' => 'CustomLoader'])
            ->willReturn(true);
        $generator1->getPriority()->willReturn(0);
        $generator2->supports($resource, 'class', ['class' => 'CustomLoader'])
            ->willReturn(true);
        $generator2->getPriority()->willReturn(2);

        $generator1->generate($resource, ['class' => 'CustomLoader'])->shouldNotBeCalled();
        $generator2->generate($resource, ['class' => 'CustomLoader'])->shouldBeCalled();

        $this->registerGenerator($generator1);
        $this->registerGenerator($generator2);
        $this->generate($resource, 'class', ['class' => 'CustomLoader']);
    }

    public function it_throws_exception_if_no_generator_found(Resource $resource)
    {
        $this->shouldThrow()->duringGenerate($resource, 'class', ['class' => 'CustomLoader']);
    }
}
