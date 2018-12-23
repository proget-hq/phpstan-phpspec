<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;

class StringStartMatcherSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $presenter->presentString(Argument::type('string'))->willReturnArgument();

        $this->beConstructedWith($presenter);
    }

    public function it_is_a_matcher()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
    }

    public function it_supports_startWith_keyword_and_string_subject()
    {
        $this->supports('startWith', 'hello, everzet', ['hello'])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else()
    {
        $this->supports('startWith', [], [])->shouldReturn(false);
    }

    public function it_matches_strings_that_start_with_specified_prefix()
    {
        $this->shouldNotThrow()->duringPositiveMatch('startWith', 'everzet', ['ev']);
    }

    public function it_does_not_match_strings_that_do_not_start_with_specified_prefix()
    {
        $this->shouldThrow()->duringPositiveMatch('startWith', 'everzet', ['av']);
    }

    public function it_matches_strings_that_do_not_start_with_specified_prefix()
    {
        $this->shouldNotThrow()->duringNegativeMatch('startWith', 'everzet', ['av']);
    }

    public function it_does_not_match_strings_that_do_start_with_specified_prefix()
    {
        $this->shouldThrow()->duringNegativeMatch('startWith', 'everzet', ['ev']);
    }
}
