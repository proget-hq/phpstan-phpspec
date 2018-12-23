<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Exception;

use PhpSpec\Formatter\Presenter\Value\ExceptionTypePresenter;
use PhpSpec\Formatter\Presenter\Value\ValuePresenter;
use PhpSpec\ObjectBehavior;

class SimpleExceptionElementPresenterSpec extends ObjectBehavior
{
    public function let(ExceptionTypePresenter $typePresenter, ValuePresenter $valuePresenter)
    {
        $this->beConstructedWith($typePresenter, $valuePresenter);
    }

    public function it_is_an_exception_element_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Exception\ExceptionElementPresenter');
    }

    public function it_should_return_a_simple_exception_thrown_message(
        ExceptionTypePresenter $typePresenter,
        \Exception $exception
    ) {
        $typePresenter->present($exception)->willReturn('exc');
        $this->presentExceptionThrownMessage($exception)->shouldReturn('Exception exc has been thrown.');
    }

    public function it_should_present_a_code_line()
    {
        $this->presentCodeLine('3', '4')->shouldReturn('3 4');
    }

    public function it_should_present_a_highlighted_line_unchanged()
    {
        $this->presentHighlight('foo')->shouldReturn('foo');
    }

    public function it_should_present_the_header_of_an_exception_trace_unchanged()
    {
        $this->presentExceptionTraceHeader('foo')->shouldReturn('foo');
    }

    public function it_should_present_every_argument_in_an_exception_trace_method_as_a_value(ValuePresenter $valuePresenter)
    {
        $args = ['foo', 42];
        $valuePresenter->presentValue('foo')->shouldBeCalled();
        $valuePresenter->presentValue(42)->shouldBeCalled();

        $this->presentExceptionTraceMethod('', '', '', $args);
    }

    public function it_should_present_an_exception_trace_method(ValuePresenter $valuePresenter)
    {
        $valuePresenter->presentValue('a')->willReturn('zaz');
        $valuePresenter->presentValue('b')->willReturn('zbz');

        $this->presentExceptionTraceMethod('class', 'type', 'method', ['a', 'b'])
            ->shouldReturn('   classtypemethod(zaz, zbz)');
    }

    public function it_should_present_every_argument_in_an_exception_trace_function_as_a_value(ValuePresenter $valuePresenter)
    {
        $args = ['foo', 42];
        $valuePresenter->presentValue('foo')->shouldBeCalled();
        $valuePresenter->presentValue(42)->shouldBeCalled();

        $this->presentExceptionTraceFunction('', $args);
    }

    public function it_should_present_an_exception_trace_function(ValuePresenter $valuePresenter)
    {
        $valuePresenter->presentValue('a')->willReturn('zaz');
        $valuePresenter->presentValue('b')->willReturn('zbz');

        $this->presentExceptionTraceFunction('function', ['a', 'b'])
            ->shouldReturn('   function(zaz, zbz)');
    }
}
