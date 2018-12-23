<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;

class StringEndMatcherSpec extends ObjectBehavior
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

    public function it_supports_endWith_keyword_and_string_subject()
    {
        $this->supports('endWith', 'hello, everzet', ['everzet'])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else()
    {
        $this->supports('endWith', [], [])->shouldReturn(false);
    }

    public function it_matches_strings_that_end_with_specified_suffix()
    {
        $this->shouldNotThrow()->duringPositiveMatch('endWith', 'everzet', ['zet']);
    }

    public function it_does_not_match_strings_that_do_not_end_with_specified_suffix()
    {
        $this->shouldThrow()->duringPositiveMatch('endWith', 'everzet', ['tez']);
    }

    public function it_matches_strings_that_do_not_end_with_specified_suffix()
    {
        $this->shouldNotThrow()->duringNegativeMatch('endWith', 'everzet', ['tez']);
    }

    public function it_does_not_match_strings_that_do_end_with_specified_suffix()
    {
        $this->shouldThrow()->duringNegativeMatch('endWith', 'everzet', ['zet']);
    }
}
