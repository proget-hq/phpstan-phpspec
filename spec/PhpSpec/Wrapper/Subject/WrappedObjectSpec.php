<?php

declare(strict_types=1);

namespace spec\PhpSpec\Wrapper\Subject;

use PhpSpec\Exception\Fracture\FactoryDoesNotReturnObjectException;
use PhpSpec\ObjectBehavior;

use PhpSpec\Formatter\Presenter\Presenter;

class WrappedObjectSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $this->beConstructedWith(null, $presenter);
    }

    public function it_instantiates_object_using_classname()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['ArrayObject']);
        $this->instantiate()->shouldHaveType('ArrayObject');
    }

    public function it_keeps_instantiated_object()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['ArrayObject']);
        $this->instantiate()->shouldBeEqualTo($this->getInstance());
    }

    public function it_can_be_instantiated_with_a_factory_method()
    {
        $this->callOnWrappedObject(
            'beConstructedThrough',
            [
                '\DateTime::createFromFormat',
                ['d-m-Y', '01-01-1970']
            ]
        );
        $this->instantiate()->shouldHaveType('\DateTime');
    }

    public function it_can_be_instantiated_with_a_factory_method_with_method_name_only()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['\DateTime']);
        $this->callOnWrappedObject(
            'beConstructedThrough',
            [
                'createFromFormat',
                ['d-m-Y', '01-01-1970']
            ]
        );
        $this->instantiate()->shouldHaveType('\DateTime');
    }

    public function it_throws_an_exception_when_factory_method_returns_a_non_object()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['\DateTimeZone']);
        $this->callOnWrappedObject('beConstructedThrough', ['listAbbreviations']);

        $message = 'The method \DateTimeZone::listAbbreviations did not return an object, returned array instead';
        $this->shouldThrow(new FactoryDoesNotReturnObjectException($message))->duringInstantiate();
    }

    public function it_throws_an_exception_when_trying_to_change_constructor_params_after_instantiation()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['\DateTime']);

        $this->callOnWrappedObject('beConstructedWith', [['now']]);
        $this->callOnWrappedObject('instantiate', []);
        $this->shouldThrow('PhpSpec\Exception\Wrapper\SubjectException')->duringBeConstructedWith(['tomorrow']);
    }

    public function it_throws_an_exception_when_trying_to_change_factory_method_after_instantiation()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['\DateTime']);

        $this->callOnWrappedObject('beConstructedThrough', ['createFromFormat',['d-m-Y', '01-01-1980']]);
        $this->callOnWrappedObject('instantiate', []);
        $this->shouldThrow('PhpSpec\Exception\Wrapper\SubjectException')
            ->duringBeConstructedThrough(['createFromFormat',['d-m-Y', '01-01-1970']]);
    }

    public function it_throws_an_exception_when_trying_to_change_from_constructor_to_factory_method_after_instantiation()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['\DateTime']);

        $this->callOnWrappedObject('beConstructedWith', [['now']]);
        $this->callOnWrappedObject('instantiate', []);
        $this->shouldThrow('PhpSpec\Exception\Wrapper\SubjectException')
            ->duringBeConstructedThrough(['createFromFormat',['d-m-Y', '01-01-1970']]);
    }

    public function it_throws_an_exception_when_trying_to_change_from_factory_method_to_constructor_after_instantiation()
    {
        $this->callOnWrappedObject('beAnInstanceOf', ['\DateTime']);

        $this->callOnWrappedObject('beConstructedThrough', ['createFromFormat',['d-m-Y', '01-01-1980']]);
        $this->callOnWrappedObject('instantiate', []);
        $this->shouldThrow('PhpSpec\Exception\Wrapper\SubjectException')->duringBeConstructedWith(['tomorrow']);
    }
}
