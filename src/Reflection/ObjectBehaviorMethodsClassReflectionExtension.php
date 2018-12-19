<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PhpSpec\Locator\PSR0\PSR0Locator;
use PhpSpec\Locator\PSR0\PSR0Resource;
use PhpSpec\Locator\ResourceLocator;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use PhpSpec\Wrapper\Subject;
use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\Type\ObjectType;
use Proget\PHPStan\PhpSpec\Exception\SpecSourceClassNotFound;

final class ObjectBehaviorMethodsClassReflectionExtension implements MethodsClassReflectionExtension, BrokerAwareExtension
{
    /**
     * @var Broker
     */
    private $broker;

    /**
     * @var ResourceLocator
     */
    private $locator;

    public function __construct()
    {
        $this->locator = new PSR0Locator(new Filesystem());
    }

    public function setBroker(Broker $broker): void
    {
        $this->broker = $broker;
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return in_array(ObjectBehavior::class, $classReflection->getParentClassesNames(), true);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $subjectReflection = $this->broker->getClass(Subject::class);
        if (0 === strpos($methodName, 'should')) {
            return $subjectReflection->getMethod($methodName, new OutOfClassScope());
        }

        if ($subjectReflection->hasNativeMethod($methodName)) {
            return $subjectReflection->getNativeMethod($methodName);
        }

        /** @var PSR0Resource[] $resources */
        $resources = $this->locator->findResources((string) $classReflection->getFileName());

        if (count($resources) === 0) {
            throw new SpecSourceClassNotFound(sprintf('Source class from %s not found', $classReflection->getName()));
        }
        $srcClassReflection = $this->broker->getClass($resources[0]->getSrcClassname());

        $method = $srcClassReflection->getNativeMethod($methodName);

        $methodReflection = new \ReflectionClass($method);
        $returnType = $methodReflection->getProperty('nativeReturnType');
        $returnType->setAccessible(true);
        $returnType->setValue($method, new ObjectType(Subject::class));

        $nativeReturnType = $methodReflection->getProperty('returnType');
        $nativeReturnType->setAccessible(true);
        $nativeReturnType->setValue($method, new ObjectType(Subject::class));

        $variants = $methodReflection->getProperty('variants');
        $variants->setAccessible(true);
        $variants->setValue($method, null);

        return $method;
    }
}
