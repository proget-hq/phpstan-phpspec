<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Value;

use PhpSpec\ObjectBehavior;

class NullTypePresenterSpec extends ObjectBehavior
{
    public function it_is_a_type_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Value\TypePresenter');
    }

    public function it_should_support_null_values()
    {
        $this->supports(null)->shouldReturn(true);
    }

    public function it_should_present_null_as_a_string()
    {
        $this->present(null)->shouldReturn('null');
    }
}
