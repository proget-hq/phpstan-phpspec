<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;

class CallbackMatcherSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $presenter->presentValue(Argument::any())->willReturn('val');
        $presenter->presentString(Argument::any())->willReturnArgument();

        $this->beConstructedWith('custom', function () {
        }, $presenter);
    }

    public function it_is_a_matcher()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
    }

    public function it_supports_same_alias_it_was_constructed_with()
    {
        $this->supports('custom', [], [])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else()
    {
        $this->supports('anything_else', [], [])->shouldReturn(false);
    }

    public function it_matches_if_callback_returns_true($presenter)
    {
        $this->beConstructedWith('custom', function () {
            return true;
        }, $presenter);

        $this->shouldNotThrow()->duringPositiveMatch('custom', [], []);
    }

    public function it_does_not_match_if_callback_returns_false($presenter)
    {
        $this->beConstructedWith('custom', function () {
            return false;
        }, $presenter);

        $this->shouldThrow()->duringPositiveMatch('custom', [], []);
    }
}
