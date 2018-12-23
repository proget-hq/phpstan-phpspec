<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Exception;

use PhpSpec\Formatter\Presenter\Exception\ExceptionElementPresenter;
use PhpSpec\ObjectBehavior;

class GenericPhpSpecExceptionPresenterSpec extends ObjectBehavior
{
    public function let(ExceptionElementPresenter $elementPresenter)
    {
        $this->beConstructedWith($elementPresenter);
    }

    public function it_is_a_phpspec_exception_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Exception\PhpSpecExceptionPresenter');
    }
}
