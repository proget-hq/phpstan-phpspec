<?php

declare(strict_types=1);

namespace spec\Proget\Tests;

use Proget\Tests\Bar;
use Proget\Tests\Baz;
use Proget\Tests\Foo;
use PhpSpec\ObjectBehavior;

class FooSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Foo::class);
    }

    public function it_should_return_int_from_baz(Bar $bar, Baz $baz): void
    {
        $bar->baz = $baz;
        $baz->someInt()->willReturn(99);

        $this->getIntFromBaz($bar)->shouldBe(99);
    }
}
