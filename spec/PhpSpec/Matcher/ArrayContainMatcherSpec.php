<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;

class ArrayContainMatcherSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $presenter->presentValue(Argument::any())->willReturn('countable');
        $presenter->presentString(Argument::any())->willReturnArgument();

        $this->beConstructedWith($presenter);
    }

    public function it_is_a_matcher()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
    }

    public function it_responds_to_contain()
    {
        $this->supports('contain', [], [''])->shouldReturn(true);
    }

    public function it_matches_array_with_specified_value()
    {
        $this->shouldNotThrow()->duringPositiveMatch('contain', ['abc'], ['abc']);
    }

    public function it_does_not_match_array_without_specified_value()
    {
        $this->shouldThrow()->duringPositiveMatch('contain', [1,2,3], ['abc']);
        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')
            ->duringPositiveMatch('contain', [1,2,3], [new \stdClass()]);
    }

    public function it_matches_array_without_specified_value()
    {
        $this->shouldNotThrow()->duringNegativeMatch('contain', [1,2,3], ['abc']);
    }
}
