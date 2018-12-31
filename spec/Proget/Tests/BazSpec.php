<?php

declare(strict_types=1);

namespace spec\Proget\Tests;

use Proget\Tests\Baz;
use PhpSpec\ObjectBehavior;

class BazSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Baz::class);
    }

    public function it_should_allow_to_enable(): void
    {
        $this->enable();

        $this->shouldBeEnabled();
    }

    public function it_should_be_disabled_by_default(): void
    {
        $this->shouldNotBeEnabled();
    }

    public function it_should_not_have_items_by_default(): void
    {
        $this->shouldNotHaveItems();
    }

    public function it_should_allow_to_add_item(): void
    {
        $this->addItem('item');

        $this->shouldHaveItems();
    }
}
