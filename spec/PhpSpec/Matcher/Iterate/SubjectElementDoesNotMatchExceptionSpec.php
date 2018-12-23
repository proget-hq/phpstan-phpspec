<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher\Iterate;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;

class SubjectElementDoesNotMatchExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(42, '"subject key"', '"subject value"', '"expected key"', '"expected value"');
    }

    public function it_is_a_failure_exception()
    {
        $this->shouldHaveType(FailureException::class);
    }

    public function it_has_a_predefined_message()
    {
        $this->getMessage()->shouldReturn('Expected subject to have element #42 with key "expected key" and value "expected value", but got key "subject key" and value "subject value".');
    }
}
