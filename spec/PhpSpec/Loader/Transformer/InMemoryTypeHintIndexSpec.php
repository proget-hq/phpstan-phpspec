<?php

declare(strict_types=1);

namespace spec\PhpSpec\Loader\Transformer;

use PhpSpec\CodeAnalysis\DisallowedNonObjectTypehintException;
use PhpSpec\ObjectBehavior;

class InMemoryTypeHintIndexSpec extends ObjectBehavior
{
    public function it_is_a_typehint_index()
    {
        $this->shouldHaveType('PhpSpec\Loader\Transformer\TypeHintIndex');
    }

    public function it_is_case_insensitive()
    {
        $this->add('Foo', 'boz', '$bar', 'Baz');

        $this->lookup('FoO', 'bOz', '$bAr')->shouldReturn('Baz');
    }

    public function it_remembers_the_typehints_that_are_added()
    {
        $this->add('Foo', 'boz', '$bar', 'Baz');

        $this->lookup('Foo', 'boz', '$bar')->shouldReturn('Baz');
    }

    public function it_returns_false_for_typehints_that_have_not_been_added()
    {
        $this->lookup('Foo', 'boz', '$bar')->shouldBe(false);
    }

    public function it_throws_invalid_argument_exceptions()
    {
        $e = new DisallowedNonObjectTypehintException();

        $this->addInvalid('Foo', 'boz', '$bar', $e);

        $this->shouldThrow($e)->duringLookup('Foo', 'boz', '$bar');
    }
}
