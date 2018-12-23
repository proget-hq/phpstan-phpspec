<?php

declare(strict_types=1);

namespace spec\PhpSpec\Loader\Node;

use PhpSpec\ObjectBehavior;

use PhpSpec\Locator\Resource;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Loader\Suite;

use ReflectionClass;

class SpecificationNodeSpec extends ObjectBehavior
{
    public function let(ReflectionClass $class, Resource $resource)
    {
        $this->beConstructedWith('specification node', $class, $resource);
    }

    public function it_is_countable()
    {
        $this->shouldImplement('Countable');
    }

    public function it_provides_a_link_to_title()
    {
        $this->getTitle()->shouldReturn('specification node');
    }

    public function it_provides_a_link_to_class($class)
    {
        $this->getClassReflection()->shouldReturn($class);
    }

    public function it_provides_a_link_to_resource($resource)
    {
        $this->getResource()->shouldReturn($resource);
    }

    public function it_provides_a_link_to_suite(Suite $suite)
    {
        $this->setSuite($suite);
        $this->getSuite()->shouldReturn($suite);
    }

    public function it_provides_a_link_to_examples(ExampleNode $example)
    {
        $this->addExample($example);
        $this->addExample($example);
        $this->addExample($example);

        $this->getExamples()->shouldReturn([$example, $example, $example]);
    }

    public function it_provides_a_count_of_examples(ExampleNode $example)
    {
        $this->addExample($example);
        $this->addExample($example);
        $this->addExample($example);

        $this->count()->shouldReturn(3);
    }
}
