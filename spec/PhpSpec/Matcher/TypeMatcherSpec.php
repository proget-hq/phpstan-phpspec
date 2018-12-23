<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\FailureException;

use ArrayObject;

class TypeMatcherSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $presenter->presentString(Argument::any())->willReturnArgument();
        $presenter->presentValue(Argument::any())->willReturn('object');

        $this->beConstructedWith($presenter);
    }

    public function it_is_a_matcher()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
    }

    public function it_responds_to_beAnInstanceOf()
    {
        $this->supports('beAnInstanceOf', '', [''])->shouldReturn(true);
    }

    public function it_responds_to_returnAnInstanceOf()
    {
        $this->supports('returnAnInstanceOf', '', [''])->shouldReturn(true);
    }

    public function it_responds_to_haveType()
    {
        $this->supports('haveType', '', [''])->shouldReturn(true);
    }

    public function it_matches_subclass_instance(ArrayObject $object)
    {
        $this->shouldNotThrow()
            ->duringPositiveMatch('haveType', $object, ['ArrayObject']);
    }

    public function it_matches_interface_instance(ArrayObject $object)
    {
        $this->shouldNotThrow()
            ->duringPositiveMatch('haveType', $object, ['ArrayAccess']);
    }

    public function it_does_not_match_wrong_class(ArrayObject $object)
    {
        $this->shouldThrow(new FailureException(
            'Expected an instance of stdClass, but got object.'
        ))->duringPositiveMatch('haveType', $object, ['stdClass']);
    }

    public function it_does_not_match_wrong_interface(ArrayObject $object)
    {
        $this->shouldThrow(new FailureException(
            'Expected an instance of SessionHandlerInterface, but got object.'
        ))->duringPositiveMatch('haveType', $object, ['SessionHandlerInterface']);
    }

    public function it_matches_other_class(ArrayObject $object)
    {
        $this->shouldNotThrow()->duringNegativeMatch('haveType', $object, ['stdClass']);
    }

    public function it_matches_other_interface()
    {
        $this->shouldNotThrow()
            ->duringNegativeMatch('haveType', $this, ['SessionHandlerInterface']);
    }
}
