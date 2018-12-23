<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher\Iterate;

use PhpSpec\ObjectBehavior;

final class SubjectHasMoreElementsExceptionSpec extends ObjectBehavior
{
    public function it_is_a_length_exception()
    {
        $this->shouldHaveType(\LengthException::class);
    }

    public function it_has_a_predefined_message()
    {
        $this->getMessage()->shouldReturn('Subject has more elements than expected.');
    }
}
