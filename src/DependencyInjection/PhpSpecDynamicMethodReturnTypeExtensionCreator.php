<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\DependencyInjection;

use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Proget\PHPStan\PhpSpec\Locator\NonFinalClassLocator;
use Proget\PHPStan\PhpSpec\Reflection\CollaboratorDynamicMethodReturnTypeExtension;

final class PhpSpecDynamicMethodReturnTypeExtensionCreator extends CompilerExtension
{
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();
        $workingDir = $this->getContainerBuilder()->parameters['currentWorkingDirectory'];
        $classes = (new NonFinalClassLocator())->locate(array_map(function (string $dir) use ($workingDir) {
            return $workingDir.DIRECTORY_SEPARATOR.ltrim($dir, DIRECTORY_SEPARATOR);
        }, $this->getContainerBuilder()->parameters['phpspecSourceFiles']));

        foreach ($classes as $class) {
            $definition = new ServiceDefinition();
            $definition->addTag('phpstan.broker.dynamicMethodReturnTypeExtension');
            $definition->setType(CollaboratorDynamicMethodReturnTypeExtension::class);
            $definition->setArguments([$class]);

            $builder->addDefinition(
                'collaborator.'.strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '', (string) $class)),
                $definition
            );
        }
    }
}
