<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Value;

use PhpSpec\ObjectBehavior;

class ArrayTypePresenterSpec extends ObjectBehavior
{
    public function it_is_a_type_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Value\TypePresenter');
    }

    public function it_should_support_array_values()
    {
        $this->supports([])->shouldReturn(true);
    }

    public function it_should_present_an_empty_array_as_a_string()
    {
        $this->present([])->shouldReturn('[array:0]');
    }

    public function it_should_present_a_populated_array_as_a_string()
    {
        $this->present(['a', 'b'])->shouldReturn('[array:2]');
    }
}
