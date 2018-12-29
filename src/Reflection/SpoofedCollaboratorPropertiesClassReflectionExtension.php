<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PhpSpec\Wrapper\Collaborator;
use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use Proget\PHPStan\PhpSpec\Registry\SpoofedCollaboratorRegistry;
use Proget\PHPStan\PhpSpec\Wrapper\SpoofedCollaborator;

final class SpoofedCollaboratorPropertiesClassReflectionExtension implements PropertiesClassReflectionExtension, BrokerAwareExtension
{
    /**
     * @var Broker
     */
    private $broker;

    public function setBroker(Broker $broker): void
    {
        $this->broker = $broker;
    }

    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        return in_array(SpoofedCollaborator::class, array_map(function (ClassReflection $interface):string {
            return $interface->getName();
        }, $classReflection->getInterfaces()), true);
    }

    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        $collaboratorClassName = (string) preg_replace('/Collaborator$/', '', SpoofedCollaboratorRegistry::getAlias($classReflection->getName()));

        return new CollaboratorPropertyReflection($this->broker->getClass($collaboratorClassName)->getProperty($propertyName, new OutOfClassScope()));
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return in_array(SpoofedCollaborator::class, array_map(function (ClassReflection $interface):string {
            return $interface->getName();
        }, $classReflection->getInterfaces()), true);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $collaboratorReflection = $this->broker->getClass(Collaborator::class);
        if ($collaboratorReflection->hasMethod($methodName)) {
            return $collaboratorReflection->getMethod($methodName, new OutOfClassScope());
        }

        $collaboratorClassName = (string) preg_replace('/Collaborator$/', '', SpoofedCollaboratorRegistry::getAlias($classReflection->getName()));

        return new CollaboratorMethodReflection($this->broker->getClass($collaboratorClassName)->getMethod($methodName, new OutOfClassScope()));
    }
}
