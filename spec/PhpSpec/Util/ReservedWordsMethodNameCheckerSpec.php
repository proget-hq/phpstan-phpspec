<?php

declare(strict_types=1);

namespace spec\PhpSpec\Util;

use PhpSpec\ObjectBehavior;

class ReservedWordsMethodNameCheckerSpec extends ObjectBehavior
{
    public function it_is_restriction_provider()
    {
        $this->shouldHaveType('PhpSpec\Util\NameChecker');
    }

    public function it_returns_true_for_not_php_restricted_name()
    {
        $this->isNameValid('foo')->shouldReturn(true);
    }

    public function it_returns_false_for___halt_compiler_function()
    {
        $this->isNameValid('__halt_compiler')->shouldReturn(false);
    }
}
