<?php

declare(strict_types=1);

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;

class FileCreationEventSpec extends ObjectBehavior
{
    private $filepath = 'foo/bar.php';

    public function let()
    {
        $this->beConstructedWith($this->filepath);
    }

    public function it_should_be_a_symfony_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    public function it_should_be_a_phpspec_event()
    {
        $this->shouldImplement('PhpSpec\Event\PhpSpecEvent');
    }

    public function it_should_return_the_created_file_path()
    {
        $this->getFilePath()->shouldReturn($this->filepath);
    }
}
