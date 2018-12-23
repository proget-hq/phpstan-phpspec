<?php

declare(strict_types=1);

namespace spec\PhpSpec\Specification;

use PhpSpec\Specification;
use PhpSpec\ObjectBehavior;

class ErrorSpecificationSpec extends ObjectBehavior
{
    public function it_is_a_specification()
    {
        $this->shouldHaveType(Specification::class);
    }
}
