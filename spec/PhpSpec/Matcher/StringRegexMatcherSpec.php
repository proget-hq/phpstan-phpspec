<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;

class StringRegexMatcherSpec extends ObjectBehavior
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

    public function it_supports_match_keyword_and_string_subject()
    {
        $this->supports('match', 'hello, everzet', ['/hello/'])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else()
    {
        $this->supports('match', [], [])->shouldReturn(false);
    }

    public function it_matches_strings_that_match_specified_regex()
    {
        $this->shouldNotThrow()->duringPositiveMatch('match', 'everzet', ['/ev.*et/']);
    }

    public function it_does_not_match_strings_that_do_not_match_specified_regex()
    {
        $this->shouldThrow()->duringPositiveMatch('match', 'everzet', ['/md/']);
    }

    public function it_matches_strings_that_do_not_match_specified_regex()
    {
        $this->shouldNotThrow()->duringNegativeMatch('match', 'everzet', ['/md/']);
    }

    public function it_does_not_match_strings_that_do_match_specified_regex()
    {
        $this->shouldThrow()->duringNegativeMatch('match', 'everzet', ['/^ev.*et$/']);
    }
}
