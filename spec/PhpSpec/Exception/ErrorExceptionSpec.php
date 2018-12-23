<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception;

use PhpSpec\ObjectBehavior;

class ErrorExceptionSpec extends ObjectBehavior
{
    private $error;

    public function let()
    {
        $this->beConstructedWith($this->error = new \Error('This is an error', 42));
    }

    public function it_is_an_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }

    public function its_message_is_the_same_as_the_errors()
    {
        $this->getMessage()->shouldEqual('This is an error');
    }

    public function its_code_is_the_same_as_the_errors()
    {
        $this->getCode()->shouldEqual(42);
    }

    public function its_previous_is_the_error()
    {
        $this->getPrevious()->shouldEqual($this->error);
    }

    public function its_line_is_the_same_as_the_errors()
    {
        $this->getLine()->shouldEqual($this->error->getLine());
    }
}
