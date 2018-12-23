<?php

declare(strict_types = 1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ObjectStateMatcherSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $presenter->presentValue(Argument::any())->willReturn('val1', 'val2');
        $presenter->presentString(Argument::any())->willReturnArgument();

        $this->beConstructedWith($presenter);
    }

    public function it_is_a_matcher()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
    }

    public function it_infers_matcher_alias_name_from_methods_prefixed_with_is()
    {
        $subject = new \ReflectionClass($this);

        $this->supports('beAbstract', $subject, [])->shouldReturn(true);
    }

    public function it_throws_exception_if_checker_method_not_found()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Fracture\MethodNotFoundException')
            ->duringPositiveMatch('beSimple', $subject, []);
    }

    public function it_matches_if_state_checker_returns_true()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldNotThrow()->duringPositiveMatch('beUserDefined', $subject, []);
    }

    public function it_does_not_match_if_state_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')
            ->duringPositiveMatch('beFinal', $subject, []);
    }

    public function it_infers_matcher_alias_name_from_methods_prefixed_with_has()
    {
        $subject = new \ReflectionClass($this);

        $this->supports('haveProperty', $subject, ['something'])->shouldReturn(true);
    }

    public function it_throws_exception_if_has_checker_method_not_found()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Fracture\MethodNotFoundException')
            ->duringPositiveMatch('haveAnything', $subject, ['str']);
    }

    public function it_matches_if_has_checker_returns_true()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldNotThrow()->duringPositiveMatch(
            'haveMethod',
            $subject,
            ['it_matches_if_has_checker_returns_true']
        );
    }

    public function it_does_not_match_if_has_state_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')
            ->duringPositiveMatch('haveProperty', $subject, ['other']);
    }

    public function it_does_not_match_if_subject_is_callable()
    {
        $subject = function () {
        };

        $this->supports('beCallable', $subject, [])->shouldReturn(false);
    }

    public function it_does_not_throw_when_positive_match_true()
    {
        $subject = new class {
            public function isMatched()
            {
                return true;
            }
        };

        $this->positiveMatch('beMatched', $subject, [])->shouldBe(null);
    }

    public function it_does_not_throw_when_negative_match_false()
    {
        $subject = new class {
            public function isMatched()
            {
                return false;
            }
        };

        $this->negativeMatch('beMatched', $subject, [])->shouldBe(null);
    }
}
