<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception\Fracture;

use PhpSpec\ObjectBehavior;

class InterfaceNotImplementedExceptionSpec extends ObjectBehavior
{
    public function let($subject)
    {
        $this->beConstructedWith('Not equal', $subject, 'ArrayAccess');
    }

    public function it_is_fracture()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Exception\Fracture\FractureException');
    }

    public function it_provides_a_link_to_subject($subject)
    {
        $this->getSubject()->shouldReturn($subject);
    }

    public function it_provides_a_link_to_interface()
    {
        $this->getInterface()->shouldReturn('ArrayAccess');
    }
}
