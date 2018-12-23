<?php

declare(strict_types=1);

namespace spec\Proget\Tests\PHPStan\PhpSpec;

use Proget\Tests\PHPStan\PhpSpec\Baz;
use Proget\Tests\PHPStan\PhpSpec\Foo;
use PhpSpec\ObjectBehavior;
use Proget\Tests\PHPStan\PhpSpec\ValueObject;

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

    public function it_should_return_empty_string(): void
    {
        $this->foo()->shouldBe('');
    }

    public function it_should_make_baz(Baz $baz): void
    {
        $baz->make()->willReturn(123);

        $this->makeBaz()->shouldBe(123);
    }

    public function it_should_make_value_object_with_provided_string(): void
    {
        $vo = $this->makeValueObject('php-ml is awesome'); // little product placement XD

        $vo->shouldBeAnInstanceOf(ValueObject::class);
        $vo->string()->shouldEqual('php-ml is awesome');
        $vo->copy()->copy()->string()->shouldEqual('php-ml is awesome');
    }
}
