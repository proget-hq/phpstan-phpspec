<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Html;

use PhpSpec\ObjectBehavior;

use Symfony\Component\Console\Input\InputInterface;

class HtmlIOSpec extends ObjectBehavior
{
    public function let(InputInterface $input)
    {
        $this->beConstructedWith($input);
    }
}
