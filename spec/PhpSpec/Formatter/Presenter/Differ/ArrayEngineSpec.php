<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Differ;

use PhpSpec\ObjectBehavior;

class ArrayEngineSpec extends ObjectBehavior
{
    public function it_is_a_diff_engine()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Formatter\Presenter\Differ\DifferEngine');
    }

    public function it_supports_arrays()
    {
        $this->supports([], [1, 2, 3])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else()
    {
        $this->supports('str', 2)->shouldReturn(false);
    }
}
