<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception\Example;

use PhpSpec\ObjectBehavior;

class NotEqualExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Not equal', 2, 5);
    }

    public function it_is_failure()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Exception\Example\FailureException');
    }

    public function it_provides_a_link_to_expected()
    {
        $this->getExpected()->shouldReturn(2);
    }

    public function it_provides_a_link_to_actual()
    {
        $this->getActual()->shouldReturn(5);
    }
}
