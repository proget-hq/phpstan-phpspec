<?php

declare(strict_types=1);

namespace spec\PhpSpec\CodeGenerator\Generator;

use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Console\ConsoleIO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;

class MethodGeneratorSpec extends ObjectBehavior
{
    public function let(ConsoleIO $io, TemplateRenderer $tpl, Filesystem $fs, CodeWriter $codeWriter)
    {
        $this->beConstructedWith($io, $tpl, $fs, $codeWriter);
    }

    public function it_is_a_generator()
    {
        $this->shouldBeAnInstanceOf('PhpSpec\CodeGenerator\Generator\Generator');
    }

    public function it_supports_method_generation(Resource $resource)
    {
        $this->supports($resource, 'method', [])->shouldReturn(true);
    }

    public function it_does_not_support_anything_else(Resource $resource)
    {
        $this->supports($resource, 'anything_else', [])->shouldReturn(false);
    }

    public function its_priority_is_0()
    {
        $this->getPriority()->shouldReturn(0);
    }

    public function it_generates_class_method_from_resource($io, $tpl, $fs, Resource $resource, CodeWriter $codeWriter)
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
            '%name%' => 'setName',
            '%arguments%' => '$argument1',
        ];

        $resource->getSrcFilename()->willReturn('/project/src/Acme/App.php');
        $resource->getSrcClassname()->willReturn('Acme\App');

        $tpl->render('method', $values)->willReturn('');
        $tpl->renderString(Argument::type('string'), $values)->willReturn('METHOD');

        $codeWriter->insertMethodLastInClass($codeWithoutMethod, 'METHOD')->willReturn($codeWithMethod);

        $fs->getFileContents('/project/src/Acme/App.php')->willReturn($codeWithoutMethod);
        $fs->putFileContents('/project/src/Acme/App.php', $codeWithMethod)->shouldBeCalled();

        $this->generate($resource, ['name' => 'setName', 'arguments' => ['everzet']]);
    }
}
