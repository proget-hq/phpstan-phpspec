<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\FailureException;

use ArrayObject;

class ArrayCountMatcherSpec extends ObjectBehavior
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

    public function it_responds_to_haveCount()
    {
        $this->supports('haveCount', [], [''])->shouldReturn(true);
    }

    public function it_matches_proper_array_count()
    {
        $this->shouldNotThrow()->duringPositiveMatch('haveCount', [1,2,3], [3]);
    }

    public function it_matches_proper_countable_count(ArrayObject $countable)
    {
        $countable->count()->willReturn(4);

        $this->shouldNotThrow()->duringPositiveMatch('haveCount', $countable, [4]);
    }

    public function it_does_not_match_wrong_array_count()
    {
        $this->shouldThrow(new FailureException('Expected countable to have 2 items, but got 3.'))
            ->duringPositiveMatch('haveCount', [1,2,3], [2]);
    }

    public function it_does_not_match_proper_countable_count(ArrayObject $countable)
    {
        $countable->count()->willReturn(5);

        $this->shouldThrow(new FailureException('Expected countable to have 4 items, but got 5.'))
            ->duringPositiveMatch('haveCount', $countable, [4]);
    }

    public function it_mismatches_wrong_array_count()
    {
        $this->shouldNotThrow()->duringNegativeMatch('haveCount', [1,2,3], [2]);
    }

    public function it_mismatches_wrong_countable_count(ArrayObject $countable)
    {
        $countable->count()->willReturn(5);

        $this->shouldNotThrow()->duringNegativeMatch('haveCount', $countable, [4]);
    }
}
