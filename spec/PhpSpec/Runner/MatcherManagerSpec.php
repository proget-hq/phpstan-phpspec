<?php

declare(strict_types=1);

namespace spec\PhpSpec\Runner;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Matcher;

class MatcherManagerSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $this->beConstructedWith($presenter);
        $presenter->presentString(Argument::cetera())->willReturn('some strong');
        $presenter->presentValue(Argument::cetera())->willReturn('some value');
    }

    public function it_searches_in_registered_matchers(Matcher $matcher)
    {
        $matcher->getPriority()->willReturn(0);
        $matcher->supports('startWith', 'hello, world', ['hello'])->willReturn(true);

        $this->add($matcher);
        $this->find('startWith', 'hello, world', ['hello'])->shouldReturn($matcher);
    }

    public function it_searches_matchers_by_their_priority(
        Matcher $matcher1,
        Matcher $matcher2
    ) {
        $matcher1->getPriority()->willReturn(2);
        $matcher1->supports('startWith', 'hello, world', ['hello'])->willReturn(true);
        $matcher2->getPriority()->willReturn(5);
        $matcher2->supports('startWith', 'hello, world', ['hello'])->willReturn(true);

        $this->add($matcher1);
        $this->add($matcher2);

        $this->find('startWith', 'hello, world', ['hello'])->shouldReturn($matcher2);
    }

    public function it_throws_MatcherNotFoundException_if_matcher_not_found()
    {
        $this->shouldThrow('PhpSpec\Exception\Wrapper\MatcherNotFoundException')
            ->duringFind('startWith', 'hello, world', ['hello']);
    }
}
