<?php

declare(strict_types=1);

namespace spec\PhpSpec\Console;

use PhpSpec\ObjectBehavior;

class ApplicationSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('test');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpSpec\Console\Application');
    }
}
