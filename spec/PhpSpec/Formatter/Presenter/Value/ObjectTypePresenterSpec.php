<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Value;

use PhpSpec\ObjectBehavior;

class ObjectTypePresenterSpec extends ObjectBehavior
{
    public function it_is_a_type_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Value\TypePresenter');
    }

    public function it_should_support_object_values()
    {
        $this->supports(new \stdClass())->shouldReturn(true);
    }

    public function it_should_present_an_object_as_a_string()
    {
        $this->present(new \stdClass())->shouldReturn('[obj:stdClass]');
    }
}
