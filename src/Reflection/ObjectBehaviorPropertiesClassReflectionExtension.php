<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PhpSpec\Locator\PSR0\PSR0Locator;
use PhpSpec\Locator\PSR0\PSR0Resource;
use PhpSpec\Locator\ResourceLocator;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use Proget\PHPStan\PhpSpec\Exception\SpecSourceClassNotFound;

final class ObjectBehaviorPropertiesClassReflectionExtension implements PropertiesClassReflectionExtension, BrokerAwareExtension
{
    /**
     * @var ResourceLocator
     */
    private $locator;

    /**
     * @var Broker
     */
    private $broker;

    public function __construct()
    {
        $this->locator = new PSR0Locator(new Filesystem());
    }

    public function setBroker(Broker $broker): void
    {
        $this->broker = $broker;
    }

    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        return in_array(ObjectBehavior::class, $classReflection->getParentClassesNames(), true);
    }

    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        /** @var PSR0Resource[] $resources */
        $resources = $this->locator->findResources((string) $classReflection->getFileName());

        if (count($resources) === 0) {
            throw new SpecSourceClassNotFound(sprintf('Source class from %s not found', $classReflection->getName()));
        }

        $className = $resources[0]->getSrcClassname();
        if (!class_exists($className)) {
            throw new SpecSourceClassNotFound(sprintf('Spec source class %s not found', $className));
        }

        $srcClassReflection = $this->broker->getClass($className);
        if ($srcClassReflection->hasProperty($propertyName)) {
            $srcClassReflection->getProperty($propertyName);
        }

        //special case to handle magic proxy call in object behavior
        if ($srcClassReflection->hasConstant($propertyName)) {
            throw new \RuntimeException('Need to implement this');
        }
    }
}
