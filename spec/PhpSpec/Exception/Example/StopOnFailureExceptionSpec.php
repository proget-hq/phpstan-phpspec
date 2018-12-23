<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception\Example;

use PhpSpec\ObjectBehavior;

class StopOnFailureExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Message', 0, null, 1);
    }

    public function it_is_an_example_exception()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Exception\Example\ExampleException');
    }

    public function it_has_a_the_result_of_the_last_spec()
    {
        $this->getResult()->shouldReturn(1);
    }
}
