<?php

declare(strict_types=1);

namespace spec\PhpSpec\NamespaceProvider;

use PhpSpec\NamespaceProvider\ComposerPsrNamespaceProvider;
use PhpSpec\NamespaceProvider\NamespaceLocation;
use PhpSpec\NamespaceProvider\NamespaceProvider;
use PhpSpec\ObjectBehavior;

class ComposerPsrNamespaceProviderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(__DIR__.'/../../..', 'spec');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ComposerPsrNamespaceProvider::class);
    }

    public function it_should_return_a_map_of_locations()
    {
        $this->getNamespaces()->shouldHaveKey('Proget\PHPStan\PhpSpec\\');
        $this->getNamespaces()->shouldHaveNamespaceLocation(
            'Proget\PHPStan\PhpSpec\\',
            'src',
            NamespaceProvider::AUTOLOADING_STANDARD_PSR4
        );
    }

    public function getMatchers(): array
    {
        return [
            'haveNamespaceLocation' => function ($subject, $namespace, $location, $standard) {
                $expectedNamespaceLocation = new NamespaceLocation(
                    $namespace,
                    $location,
                    $standard
                );
                foreach ($subject as $namespaceLocation) {
                    if ($namespaceLocation == $expectedNamespaceLocation) {
                        return true;
                    }
                }

                return false;
            }
        ];
    }
}
