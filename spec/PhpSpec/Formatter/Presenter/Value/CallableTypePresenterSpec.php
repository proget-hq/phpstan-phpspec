<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Presenter\Value;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;

class CallableTypePresenterSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $this->beConstructedWith($presenter);
    }

    public function it_is_a_type_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Value\TypePresenter');
    }

    public function it_should_support_callable_values()
    {
        $this->supports(function () {
        })->shouldReturn(true);
    }

    public function it_should_present_a_closure()
    {
        $this->present(function () {
        })->shouldReturn('[closure]');
    }

    public function it_should_present_function_callable_as_string()
    {
        $this->present('date')->shouldReturn('[date()]');
    }

    public function it_should_present_a_method_as_string(
        WithMethod $object,
        Presenter $presenter
    ) {
        $className = get_class($object->getWrappedObject());

        $presenter->presentValue($object->getWrappedObject())->willReturn(sprintf('[obj:%s]', $className));

        $this->present([$object, 'specMethod'])
            ->shouldReturn(sprintf('[obj:%s]::specMethod()', $className));
    }

    public function it_should_present_a_magic_method_as_string(
        WithMagicCall $object,
        Presenter $presenter
    ) {
        $className = get_class($object->getWrappedObject());

        $presenter->presentValue($object->getWrappedObject())->willReturn(sprintf('[obj:%s]', $className));

        $this->present([$object, 'undefinedMethod'])
            ->shouldReturn(sprintf('[obj:%s]::undefinedMethod()', $className));
    }

    public function it_should_present_a_static_method_as_string(WithMethod $object)
    {
        $className = get_class($object->getWrappedObject());
        $this->present([$className, 'specMethod'])
            ->shouldReturn(sprintf('%s::specMethod()', $className));
    }

    public function it_should_present_a_static_magic_method_as_string()
    {
        $className = __NAMESPACE__.'\\WithStaticMagicCall';
        $this->present([$className, 'undefinedMethod'])
            ->shouldReturn(sprintf('%s::undefinedMethod()', $className));
    }

    public function it_should_present_an_invokable_object_as_string(WithMagicInvoke $object)
    {
        $className = get_class($object->getWrappedObject());
        $this->present($object)->shouldReturn(sprintf('[obj:%s]', $className));
    }
}

class WithMethod
{
    public function specMethod()
    {
    }
}

class WithStaticMethod
{
    public function specMethod()
    {
    }
}

class WithMagicInvoke
{
    public function __invoke()
    {
    }
}

class WithStaticMagicCall
{
    public static function __callStatic($method, $name)
    {
    }
}

class WithMagicCall
{
    public function __call($method, $name)
    {
    }
}
