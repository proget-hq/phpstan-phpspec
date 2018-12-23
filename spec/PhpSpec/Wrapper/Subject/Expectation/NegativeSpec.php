<?php

declare(strict_types=1);

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\ObjectBehavior;

use PhpSpec\Matcher\Matcher;

class NegativeSpec extends ObjectBehavior
{
    public function let(Matcher $matcher)
    {
        $this->beConstructedWith($matcher);
    }

    public function it_calls_a_negative_match_on_matcher(Matcher $matcher)
    {
        $alias = 'somealias';
        $subject = 'subject';
        $arguments = [];

        $matcher->negativeMatch($alias, $subject, $arguments)->shouldBeCalled();
        $this->match($alias, $subject, $arguments);
    }
}
