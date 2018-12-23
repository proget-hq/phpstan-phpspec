<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Differ;

use PhpSpec\Formatter\Presenter\Differ\StringEngine;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SebastianBergmann\Exporter\Exporter;

class ObjectEngineSpec extends ObjectBehavior
{
    public function let(Exporter $exporter, StringEngine $stringDiffer)
    {
        $this->beConstructedWith($exporter, $stringDiffer);
    }

    public function it_is_a_differ_engine()
    {
        $this->shouldHaveType('PhpSpec\Formatter\Presenter\Differ\DifferEngine');
    }

    public function it_does_not_support_scalars()
    {
        $this->supports(1, 2)->shouldReturn(false);
    }

    public function it_only_supports_objects()
    {
        $this->supports(new \stdClass(), new \stdClass())->shouldReturn(true);
    }

    public function it_converts_objects_to_string_and_diffs_the_result(Exporter $exporter, StringEngine $stringDiffer)
    {
        $exporter->export(Argument::type('DateTime'))->willReturn('DateTime');
        $exporter->export(Argument::type('ArrayObject'))->willReturn('ArrayObject');

        $stringDiffer->compare('DateTime', 'ArrayObject')->willReturn('-DateTime+ArrayObject');

        $diff = $this->compare(new \DateTime(), new \ArrayObject());

        $diff->shouldBe('-DateTime+ArrayObject');
    }
}
