<?php

declare(strict_types=1);

namespace spec\PhpSpec\Config;

use PhpSpec\ObjectBehavior;

class OptionsConfigSpec extends ObjectBehavior
{
    public function it_says_rerun_is_enabled_when_setting_is_true()
    {
        $this->beConstructedWith(false, false, true, false, false, false);

        $this->isReRunEnabled()->shouldReturn(true);
    }

    public function it_says_rerun_is_not_enabled_when_setting_is_false()
    {
        $this->beConstructedWith(false, false, false, false, false, false);

        $this->isReRunEnabled()->shouldReturn(false);
    }

    public function it_says_faking_is_enabled_when_setting_is_true()
    {
        $this->beConstructedWith(false, false, false, true, false, false);

        $this->isFakingEnabled()->shouldReturn(true);
    }

    public function it_says_faking_is_not_enabled_when_setting_is_false()
    {
        $this->beConstructedWith(false, false, false, false, false, false);

        $this->isFakingEnabled()->shouldReturn(false);
    }

    public function it_says_bootstrap_path_is_false_when_setting_is_false()
    {
        $this->beConstructedWith(false, false, false, false, false, false);

        $this->getBootstrapPath()->shouldReturn(false);
    }

    public function it_returns_bootstrap_path_when_one_is_specified()
    {
        $this->beConstructedWith(false, false, false, false, '/path/to/file', false);

        $this->getBootstrapPath()->shouldReturn('/path/to/file');
    }

    public function it_returns_verbose_when_setting_is_true()
    {
        $this->beConstructedWith(false, false, false, false, false, true);

        $this->isVerbose()->shouldReturn(true);
    }

    public function it_returns_verbose_when_setting_is_false()
    {
        $this->beConstructedWith(false, false, false, false, false, false);

        $this->isVerbose()->shouldReturn(false);
    }
}
