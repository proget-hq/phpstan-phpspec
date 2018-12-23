<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Value;

use PhpSpec\Exception\ErrorException;
use PhpSpec\ObjectBehavior;

class BaseExceptionTypePresenterSpec extends ObjectBehavior
{
    public function it_is_a_type_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Value\ExceptionTypePresenter');
    }

    public function it_should_support_exceptions()
    {
        $this->supports(new \Exception())->shouldReturn(true);
    }

    public function it_should_present_an_exception_as_a_string()
    {
        $this->present(new \Exception('foo'))
            ->shouldReturn('[exc:Exception("foo")]');
    }

    public function it_should_present_an_error_as_a_string()
    {
        $this->present(new ErrorException(new \Error('foo')))
            ->shouldReturn('[err:Error("foo")]');
    }
}
