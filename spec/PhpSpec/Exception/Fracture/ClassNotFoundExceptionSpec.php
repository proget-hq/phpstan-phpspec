<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception\Fracture;

use PhpSpec\ObjectBehavior;

class ClassNotFoundExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Not equal', 'stdClass');
    }

    public function it_is_fracture()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Exception\Fracture\FractureException');
    }

    public function it_provides_a_link_to_classname()
    {
        $this->getClassname()->shouldReturn('stdClass');
    }
}
