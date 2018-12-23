<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Exception;

use PhpSpec\Formatter\Presenter\Differ\Differ;
use PhpSpec\Formatter\Presenter\Exception\CallArgumentsPresenter;
use PhpSpec\Formatter\Presenter\Exception\ExceptionElementPresenter;
use PhpSpec\Formatter\Presenter\Exception\PhpSpecExceptionPresenter;
use PhpSpec\ObjectBehavior;

class SimpleExceptionPresenterSpec extends ObjectBehavior
{
    public function let(
        Differ $differ,
        ExceptionElementPresenter $exceptionElementPresenter,
        CallArgumentsPresenter $callArgumentsPresenter,
        PhpSpecExceptionPresenter $phpspecExceptionPresenter
    ) {
        $this->beConstructedWith(
            $differ,
            $exceptionElementPresenter,
            $callArgumentsPresenter,
            $phpspecExceptionPresenter
        );
    }

    public function it_is_an_exception_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Exception\ExceptionPresenter');
    }
}
