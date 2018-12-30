<?php

declare(strict_types=1);

namespace spec\Proget\Tests;

use Proget\Tests\Baz;
use PhpSpec\ObjectBehavior;

class BazSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Baz::class);
    }

    public function it_should_allow_to_enable(): void
    {
        $this->enable();

        $this->shouldBeEnabled();
    }
}
