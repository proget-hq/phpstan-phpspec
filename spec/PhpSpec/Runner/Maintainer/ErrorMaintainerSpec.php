<?php

declare(strict_types=1);

namespace spec\PhpSpec\Runner\Maintainer;

use PhpSpec\Exception\Example as ExampleException;
use PhpSpec\ObjectBehavior;
use PhpSpec\Runner\Maintainer\ErrorMaintainer;

class ErrorMaintainerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(0);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ErrorMaintainer::class);
    }

    public function it_return_false_when_error_suppresed_or_no_error_reporting()
    {
        $oldLevel = error_reporting(0);
        $this->errorHandler(0, 'error message', 'file', 1)->shouldBe(false);
        error_reporting($oldLevel);
    }

    public function it_return_true_when_recoverable_level_and_message_match()
    {
        $msg = 'Argument 1 passed to '.self::class.'::test() must be an instance of string, string given';
        $this->errorHandler(E_RECOVERABLE_ERROR, $msg, 'file', 1)->shouldBe(true);
    }

    public function it_throws_error_exception_when_message_not_match()
    {
        $this->shouldThrow(ExampleException\ErrorException::class)
             ->during('errorHandler', [0, 'error message', 'file', 1]);
    }
}
