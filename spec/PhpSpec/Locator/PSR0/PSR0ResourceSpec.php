<?php

declare(strict_types=1);

namespace spec\PhpSpec\Locator\PSR0;

use PhpSpec\ObjectBehavior;

use PhpSpec\Locator\PSR0\PSR0Locator as Locator;

class PSR0ResourceSpec extends ObjectBehavior
{
    public function let(Locator $locator)
    {
        $this->beConstructedWith(['usr', 'lib', 'config'], $locator);

        $locator->isPSR4()->willReturn(false);
    }

    public function it_uses_last_segment_as_name()
    {
        $this->getName()->shouldReturn('config');
    }

    public function it_uses_last_segment_plus_Spec_suffix_as_specName()
    {
        $this->getSpecName()->shouldReturn('configSpec');
    }

    public function it_is_a_resource()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\Locator\Resource');
    }

    public function it_generates_src_filename_from_provided_parts_using_locator($locator)
    {
        $locator->getFullSrcPath()->willReturn('/local/');

        $this->getSrcFilename()->shouldReturn('/local/usr'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'config.php');
    }

    public function it_generates_src_namespace_from_provided_parts_using_locator($locator)
    {
        $locator->getSrcNamespace()->willReturn('Local\\');

        $this->getSrcNamespace()->shouldReturn('Local\usr\lib');
    }

    public function it_generates_proper_src_namespace_even_if_there_is_only_one_part($locator)
    {
        $this->beConstructedWith(['config'], $locator);
        $locator->getSrcNamespace()->willReturn('Local\\');

        $this->getSrcNamespace()->shouldReturn('Local');
    }

    public function it_generates_src_classname_from_provided_parts_using_locator($locator)
    {
        $locator->getSrcNamespace()->willReturn('Local\\');

        $this->getSrcClassname()->shouldReturn('Local\usr\lib\config');
    }

    public function it_generates_proper_src_classname_for_empty_locator_namespace($locator)
    {
        $locator->getSrcNamespace()->willReturn('');

        $this->getSrcClassname()->shouldReturn('usr\lib\config');
    }

    public function it_generates_spec_filename_from_provided_parts_using_locator($locator)
    {
        $locator->getFullSpecPath()->willReturn('/local/spec/');

        $this->getSpecFilename()->shouldReturn('/local/spec/usr'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'configSpec.php');
    }

    public function it_generates_spec_namespace_from_provided_parts_using_locator($locator)
    {
        $locator->getSpecNamespace()->willReturn('spec\Local\\');

        $this->getSpecNamespace()->shouldReturn('spec\Local\usr\lib');
    }

    public function it_generates_proper_spec_namespace_even_if_there_is_only_one_part($locator)
    {
        $this->beConstructedWith(['config'], $locator);
        $locator->getSpecNamespace()->willReturn('spec\Local\\');

        $this->getSpecNamespace()->shouldReturn('spec\Local');
    }

    public function it_generates_spec_classname_from_provided_parts_using_locator($locator)
    {
        $locator->getSpecNamespace()->willReturn('spec\Local\\');

        $this->getSpecClassname()->shouldReturn('spec\Local\usr\lib\configSpec');
    }

    public function it_does_not_split_underscores_when_locator_has_psr4_prefix($locator)
    {
        $this->beConstructedWith(['usr', 'lib', 'config_test'], $locator);

        $locator->getFullSrcPath()->willReturn($this->convert_to_path('/local/'));
        $locator->getFullSpecPath()->willReturn($this->convert_to_path('/local/spec/'));
        $locator->isPSR4()->willReturn(true);

        $this->getSrcFilename()->shouldReturn($this->convert_to_path('/local/usr/lib/config_test.php'));
        $this->getSpecFilename()->shouldReturn($this->convert_to_path('/local/spec/usr/lib/config_testSpec.php'));
    }

    private function convert_to_path($path)
    {
        if ('/' === DIRECTORY_SEPARATOR) {
            return $path;
        }

        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
