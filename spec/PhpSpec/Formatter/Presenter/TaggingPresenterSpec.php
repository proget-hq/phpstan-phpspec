<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;

class TaggingPresenterSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $this->beConstructedWith($presenter);
    }

    public function it_is_a_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Presenter');
    }

    public function it_should_tag_strings()
    {
        $this->presentString('foo')->shouldReturn('<value>foo</value>');
    }

    public function it_should_tag_values_from_the_decorated_presenter(Presenter $presenter)
    {
        $presenter->presentValue('foo')->willReturn('zfooz');
        $this->presentValue('foo')->shouldReturn('<value>zfooz</value>');
    }

    public function it_should_return_presented_exceptions_from_the_decorated_presenter_unchanged(
        Presenter $presenter,
        \Exception $exception
    ) {
        $presenter->presentException($exception, true)->willReturn('exc');
        $this->presentException($exception, true)->shouldReturn('exc');
    }
}
