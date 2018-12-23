<?php

declare(strict_types=1);

namespace spec\PhpSpec\CodeGenerator\Generator;

use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Locator\Resource;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use Prophecy\Argument;

class NamedConstructorGeneratorSpec extends ObjectBehavior
{
    public function let(ConsoleIO $io, TemplateRenderer $tpl, Filesystem $fs, CodeWriter $codeWriter)
    {
        $this->beConstructedWith($io, $tpl, $fs, $codeWriter);
    }

    public function it_is_a_generator()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\CodeGenerator\Generator\Generator');
    }

    public function it_supports_static_constructor_generation(Resource $resource)
    {
        $this->supports($resource, 'named_constructor', [])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else(Resource $resource)
    {
        $this->supports($resource, 'anything_else', [])->shouldReturn(false);
    }

    public function its_priority_is_0()
    {
        $this->getPriority()->shouldReturn(0);
    }

    public function it_generates_static_constructor_method_from_resource($io, $tpl, $fs, Resource $resource, CodeWriter $codeWriter)
    {
        $codeWithoutMethod = <<<CODE
<?php

namespace Acme;

class App
{
}

CODE;
        $codeWithMethod = <<<CODE
<?php

namespace Acme;

class App
{
METHOD
}

CODE;
        $values = [
            '%methodName%' => 'setName',
            '%arguments%' => '$argument1',
            '%returnVar%' => '$app',
            '%className%' => 'App',
            '%constructorArguments%' => ''
        ];

        $resource->getSrcFilename()->willReturn('/project/src/Acme/App.php');
        $resource->getSrcClassname()->willReturn('Acme\App');
        $resource->getName()->willReturn('App');

        $tpl->render('named_constructor_create_object', $values)->willReturn('');
        $tpl->renderString(Argument::type('string'), $values)->willReturn('METHOD');

        $codeWriter->insertAfterMethod($codeWithoutMethod, '__construct', 'METHOD')->willReturn($codeWithMethod);

        $fs->getFileContents('/project/src/Acme/App.php')->willReturn($codeWithoutMethod);
        $fs->putFileContents('/project/src/Acme/App.php', $codeWithMethod)->shouldBeCalled();

        $this->generate($resource, ['name' => 'setName', 'arguments' => ['jmurphy']]);
    }
}
