<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Value;

use PhpSpec\ObjectBehavior;

class QuotingStringTypePresenterSpec extends ObjectBehavior
{
    public function it_is_a_string_type_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Value\StringTypePresenter');
    }

    public function it_should_support_string_values()
    {
        $this->supports('')->shouldReturn(true);
        $this->supports('foo')->shouldReturn(true);
    }

    public function it_should_present_a_string_as_a_quoted_string()
    {
        $this->present('')->shouldReturn('""');
        $this->present('foo')->shouldReturn('"foo"');
    }
}
