<?php

declare(strict_types=1);

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpSpec\Matcher;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringContainMatcherSpec extends ObjectBehavior
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

    public function it_supports_contain_keyword_string_subject_and_argument()
    {
        $this->supports('contain', 'hello world', ['llo'])->shouldReturn(true);
    }

    public function it_does_not_support_non_string_keyword()
    {
        $this->supports('contain', [], [])->shouldReturn(false);
    }

    public function it_does_not_support_missing_argument()
    {
        $this->supports('contain', 'hello world', [])->shouldReturn(false);
    }

    public function it_does_not_support_non_string_argument()
    {
        $this->supports('contain', 'hello world', [[]])->shouldReturn(false);
    }

    public function it_matches_strings_that_contain_specified_substring()
    {
        $this->shouldNotThrow()->duringPositiveMatch('contains', 'hello world', ['ello']);
    }

    public function it_does_not_match_strings_that_do_not_contain_specified_substring()
    {
        $this->shouldThrow()->duringPositiveMatch('contains', 'hello world', ['row']);
    }

    public function it_matches_strings_that_do_not_contain_specified_substring()
    {
        $this->shouldNotThrow()->duringNegativeMatch('contains', 'hello world', ['row']);
    }

    public function it_does_not_match_strings_that_do_contain_specified_substring()
    {
        $this->shouldThrow()->duringNegativeMatch('contains', 'hello world', ['ello']);
    }
}
