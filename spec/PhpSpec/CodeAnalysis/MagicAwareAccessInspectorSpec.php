<?php

declare(strict_types=1);

namespace spec\PhpSpec\CodeAnalysis;

use PhpSpec\CodeAnalysis\AccessInspector;
use PhpSpec\ObjectBehavior;

class MagicAwareAccessInspectorSpec extends ObjectBehavior
{
    public function let(AccessInspector $accessInspector)
    {
        $this->beConstructedWith($accessInspector);
    }

    public function it_should_be_an_access_inspector()
    {
        $this->shouldImplement('PhpSpec\CodeAnalysis\AccessInspector');
    }

    public function it_should_detect_a_magic_getter_if_no_value_is_given()
    {
        $this->isPropertyReadable(new ObjectWithMagicGet, 'property')->shouldReturn(true);
    }

    public function it_should_detect_a_magic_setter_if_a_value_is_given()
    {
        $this->isPropertyWritable(new ObjectWithMagicSet, 'property', true)->shouldReturn(true);
    }

    public function it_should_detect_a_magic_call_method()
    {
        $this->isMethodCallable(new ObjectWithMagicCall, 'method')->shouldreturn(true);
    }

    public function it_should_not_detect_a_getter_if_there_is_no_magic_getter_and_wrapped_inspector_finds_none(AccessInspector $accessInspector)
    {
        $accessInspector->isPropertyReadable(new \stdClass(), 'foo')->willReturn(false);

        $this->isPropertyReadable(new \stdClass(), 'foo')->shouldReturn(false);
    }

    public function it_should_detect_a_getter_if_there_is_no_magic_getter_but_wrapped_inspector_finds_one(AccessInspector $accessInspector)
    {
        $accessInspector->isPropertyReadable(new \stdClass(), 'foo')->willReturn(true);

        $this->isPropertyReadable(new \stdClass(), 'foo')->shouldReturn(true);
    }

    public function it_should_not_detect_a_setter_if_there_is_no_magic_setter_and_wrapped_inspector_finds_none(AccessInspector $accessInspector)
    {
        $accessInspector->isPropertyWritable(new \stdClass(), 'foo')->willReturn(false);

        $this->isPropertyWritable(new \stdClass(), 'foo')->shouldReturn(false);
    }

    public function it_should_detect_a_setter_if_there_is_no_magic_setter_but_wrapped_inspector_finds_one(AccessInspector $accessInspector)
    {
        $accessInspector->isPropertyWritable(new \stdClass(), 'foo')->willReturn(true);

        $this->isPropertyWritable(new \stdClass(), 'foo')->shouldReturn(true);
    }

    public function it_should_detect_a_method_if_there_is_no_magic_caller_and_wrapped_inspector_finds_none(AccessInspector $accessInspector)
    {
        $accessInspector->isMethodCallable(new \stdClass(), 'foo')->willReturn(false);

        $this->isMethodCallable(new \stdClass(), 'foo')->shouldReturn(false);
    }

    public function it_should_detect_a_method_if_there_is_no_magic_caller_but_wrapped_inspector_finds_one(AccessInspector $accessInspector)
    {
        $accessInspector->isMethodCallable(new \stdClass(), 'foo')->willReturn(true);

        $this->isMethodCallable(new \stdClass(), 'foo')->shouldReturn(true);
    }
}

class ObjectWithMagicGet
{
    public function __get($name)
    {
    }
}

class ObjectWithMagicSet
{
    public function __set($name, $value)
    {
    }
}

class ObjectWithMagicCall
{
    public function __call($name, $args)
    {
    }
}
