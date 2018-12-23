<?php

declare(strict_types=1);

namespace spec\PhpSpec\Exception\Fracture;

use PhpSpec\ObjectBehavior;

class MethodNotVisibleExceptionSpec extends ObjectBehavior
{
    public function let($subject)
    {
        $this->beConstructedWith('No method', $subject, 'setName', ['everzet']);
    }

    public function it_is_fracture()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Exception\Fracture\FractureException');
    }

    public function it_provides_a_link_to_subject($subject)
    {
        $this->getSubject()->shouldReturn($subject);
    }

    public function it_provides_a_link_to_methodName()
    {
        $this->getMethodName()->shouldReturn('setName');
    }

    public function it_provides_a_link_to_arguments()
    {
        $this->getArguments()->shouldReturn(['everzet']);
    }
}
