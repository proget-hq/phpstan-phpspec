<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class TraversableContainMatcherSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $presenter->presentValue(Argument::any())->willReturn('traversable');

        $this->beConstructedWith($presenter);
    }

    public function it_is_a_matcher()
    {
        $this->shouldBeAnInstanceOf(Matcher::class);
    }

    public function it_responds_to_contain()
    {
        $this->supports('contain', $this->createGeneratorReturningValues([]), [''])->shouldReturn(true);
    }

    public function it_positive_matches_generator_with_specified_value()
    {
        $this
            ->shouldNotThrow()
            ->during('positiveMatch', ['contain', $this->createGeneratorReturningValues(['abc', 'def']), ['def']])
        ;
    }

    public function it_does_not_positive_match_generator_without_specified_value()
    {
        $this
            ->shouldThrow(FailureException::class)
            ->during('positiveMatch', ['contain', $this->createGeneratorReturningValues(['def']), ['abc']])
        ;
    }

    public function it_negative_matches_generator_without_specified_value()
    {
        $this
            ->shouldNotThrow()
            ->during('negativeMatch', ['contain', $this->createGeneratorReturningValues(['abc']), ['def']])
        ;
    }

    public function it_does_not_negative_matches_generator_with_specified_value()
    {
        $this
            ->shouldThrow(FailureException::class)
            ->during('negativeMatch', ['contain', $this->createGeneratorReturningValues(['abc', 'def']), ['def']])
        ;
    }

    /**
     * @param array $values
     *
     * @return \Generator
     */
    private function createGeneratorReturningValues(array $values)
    {
        foreach ($values as $value) {
            yield $value;
        }
    }
}
