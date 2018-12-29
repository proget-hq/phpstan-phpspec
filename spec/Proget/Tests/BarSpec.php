<?php

declare(strict_types=1);

namespace spec\Proget\Tests;

use Proget\Tests\Bar;
use PhpSpec\ObjectBehavior;
use Proget\Tests\Foo;

class BarSpec extends ObjectBehavior
{
    public function let(Foo $foo): void
    {
        $this->beConstructedWith($foo);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Bar::class);
    }

    public function it_should_return_foo_property(Foo $foo): void
    {
        $foo->property = 'Some text';

        $this->getFooProperty()->shouldBe('Some text');
    }
}
