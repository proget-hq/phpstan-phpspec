<?php

declare(strict_types=1);

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;

class PositiveSpec extends ObjectBehavior
{
    public function let(Matcher $matcher)
    {
        $this->beConstructedWith($matcher);
    }

    public function it_calls_a_positive_match_on_matcher(Matcher $matcher)
    {
        $alias = 'somealias';
        $subject = 'subject';
        $arguments = [];

        $matcher->positiveMatch($alias, $subject, $arguments)->shouldBeCalled();
        $this->match($alias, $subject, $arguments);
    }
}
