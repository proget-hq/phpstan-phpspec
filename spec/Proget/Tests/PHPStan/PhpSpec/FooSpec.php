<?php

declare(strict_types=1);

namespace spec\Proget\Tests\PHPStan\PhpSpec;

use Proget\Tests\PHPStan\PhpSpec\Baz;
use Proget\Tests\PHPStan\PhpSpec\Foo;
use PhpSpec\ObjectBehavior;

class FooSpec extends ObjectBehavior
{
    public function let(Baz $baz): void
    {
        $this->beConstructedWith($baz);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Foo::class);
    }

    public function it_should_make_baz(Baz $baz): void
    {
        $baz->make()->willReturn(123);

        $this->makeBaz()->shouldBe(123);
    }
}
