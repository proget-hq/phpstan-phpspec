<?php

declare(strict_types=1);

namespace spec\PhpSpec\CodeAnalysis;

use PhpSpec\CodeAnalysis\DisallowedNonObjectTypehintException;
use PhpSpec\CodeAnalysis\NamespaceResolver;
use PhpSpec\Loader\Transformer\TypeHintIndex;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TokenizedTypeHintRewriterSpec extends ObjectBehavior
{
    public function let(TypeHintIndex $typeHintIndex, NamespaceResolver $namespaceResolver)
    {
        $this->beConstructedWith($typeHintIndex, $namespaceResolver);
        $namespaceResolver->resolve(Argument::cetera())->willReturn('someClass');
        $namespaceResolver->analyse(Argument::any())->shouldBeCalled();
    }

    public function it_is_a_typehint_rewriter(TypeHintIndex $typeHintIndex, NamespaceResolver $namespaceResolver)
    {
        $this->beConstructedWith($typeHintIndex, $namespaceResolver);
        $namespaceResolver->resolve(Argument::cetera())->willReturn('someClass');
        $namespaceResolver->analyse(Argument::any())->shouldNotBeCalled();

        $this->shouldHaveType('PhpSpec\CodeAnalysis\TypeHintRewriter');
    }

    public function it_leaves_alone_specs_with_no_typehints()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar()
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar()
            {
            }
        }

        ');
    }

    public function it_removes_typehints_from_single_argument_methods()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(\Foo\Bar $bar)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar)
            {
            }
        }

        ');
    }

    public function it_does_not_remove_typehints_in_methods()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(\Foo\Bar $bar)
            {
                new class($argument) implements InterfaceName
                {
                    public function foo(Foo $foo) {}
                };
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar)
            {
                new class($argument) implements InterfaceName
                {
                    public function foo(Foo $foo) {}
                };
            }
        }

        ');
    }

    public function it_removes_typehints_for_multiple_arguments_in_methods()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar $bar, Baz $baz)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar,  $baz)
            {
            }
        }

        ');
    }

    public function it_indexes_typehints_that_are_removed(TypeHintIndex $typeHintIndex, NamespaceResolver $namespaceResolver)
    {
        $namespaceResolver->analyse(Argument::any())->shouldBeCalled();

        $namespaceResolver->resolve('FooSpec')->willReturn('FooSpec');
        $namespaceResolver->resolve('Foo\Bar')->willReturn('Foo\Bar');
        $namespaceResolver->resolve('Baz')->willReturn('Baz');

        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Foo\Bar $bar, Baz $baz)
            {
            }
        }

        ');

        $typeHintIndex->add('FooSpec', 'bar', '$bar', 'Foo\Bar')->shouldHaveBeenCalled();
        $typeHintIndex->add('FooSpec', 'bar', '$baz', 'Baz')->shouldHaveBeenCalled();
    }

    public function it_indexes_invalid_typehints(
        TypeHintIndex $typeHintIndex,
        NamespaceResolver $namespaceResolver
    ) {
        $e = new DisallowedNonObjectTypehintException();
        $namespaceResolver->analyse(Argument::any())->shouldBeCalled();

        $namespaceResolver->resolve('FooSpec')->willReturn('FooSpec');
        $namespaceResolver->resolve('int')->willThrow($e);

        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(int $bar)
            {
            }
        }

        ');

        $typeHintIndex->addInvalid('FooSpec', 'bar', '$bar', $e)->shouldHaveBeenCalled();
        $typeHintIndex->add('FooSpec', 'bar', '$bar', Argument::any())->shouldNotHaveBeenCalled();
    }

    public function it_preserves_line_numbers()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function(
                $foo,
                array $bar,
                Foo\Bar $arg3,
                $arg4
            )
            {
            }
        }
        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function(
                $foo,
                array $bar,
                 $arg3,
                $arg4
            )
            {
            }
        }
        ');
    }

    public function it_do_not_remove_typehints_of_non_spec_classes()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar $bar, Baz $baz)
            {
            }
        }

        class Bar
        {
            public function foo(Baz $baz)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar,  $baz)
            {
            }
        }

        class Bar
        {
            public function foo(Baz $baz)
            {
            }
        }

        ');
    }
}
