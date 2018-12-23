<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Exception;

use PhpSpec\ObjectBehavior;

class HtmlPhpSpecExceptionPresenterSpec extends ObjectBehavior
{
    public function it_is_a_phpspec_exception_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Exception\PhpSpecExceptionPresenter');
    }
}
