<?php

declare(strict_types=1);

namespace spec\PhpSpec\Message;

use PhpSpec\ObjectBehavior;

class CurrentExampleTrackerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpSpec\Message\CurrentExampleTracker');
    }

    public function it_should_set_a_message()
    {
        $this->setCurrentExample('test');
        $this->getCurrentExample()->shouldBe('test');
    }

    public function it_should_be_null_on_construction()
    {
        $this->getCurrentExample()->shouldBe(null);
    }
}
