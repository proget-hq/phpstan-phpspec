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
        $objectBehaviorReflection = $this->broker->getClass(ObjectBehavior::class);
        if ($objectBehaviorReflection->hasMethod($methodName)) {
            return $objectBehaviorReflection->getMethod($methodName, new OutOfClassScope());
        }
        // all calls on ObjectBehavior are also proxed to Subject
        $subjectReflection = $this->broker->getClass(Subject::class);
        if ($subjectReflection->hasMethod($methodName)) {
            return $subjectReflection->getMethod($methodName, new OutOfClassScope());
        }

        $sourceClass = $this->getSourceClassName($classReflection);

        if (preg_match('/^should((Not)?)(Be|Have)(.+)$/', $methodName)) {
            return $this->broker->getClass($sourceClass)->getMethod(str_replace(['shouldBe', 'shouldNotBe', 'shouldHave', 'shouldNotHave'], ['is', 'is', 'has', 'has'], $methodName), new OutOfClassScope());
        }

        return new ObjectBehaviorMethodReflection(
            $this->broker->getClass($sourceClass)->getMethod($methodName, new OutOfClassScope())
        );
    }

    private function getSourceClassName(ClassReflection $classReflection): string
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

        return $className;
    }
}
