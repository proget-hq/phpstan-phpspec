<?php

declare(strict_types=1);

namespace spec\PhpSpec\Formatter\Html;

use PhpSpec\ObjectBehavior;

use PhpSpec\IO\IO;

class TemplateSpec extends ObjectBehavior
{
    public function let(IO $io)
    {
        $this->beConstructedWith($io);
    }

    public function it_renders_the_string_as_is($io)
    {
        $this->render('text');

        $io->write('text')->shouldHaveBeenCalled();
    }

    public function it_renders_a_variable($io)
    {
        $this->render('hello {name}', ['name' => 'Chuck Norris']);
        $io->write('hello Chuck Norris')->shouldHaveBeenCalled();
    }

    public function it_works_for_many_instances_of_vars($io)
    {
        $this->render('{name}! {greeting}, {name}', [
            'name' => 'Chuck',
            'greeting' => 'hello'
        ]);
        $io->write('Chuck! hello, Chuck')->shouldHaveBeenCalled();
    }

    public function it_renders_a_file($io)
    {
        $tempFile = __DIR__.'/_files/TemplateRenderFixture.tpl';
        mkdir(__DIR__.'/_files');
        file_put_contents($tempFile, 'hello, {name}');

        $this->render($tempFile, ['name' => 'Chuck']);

        $io->write('hello, Chuck')->shouldHaveBeenCalled();
    }

    public function letgo()
    {
        if (file_exists(__DIR__.'/_files/TemplateRenderFixture.tpl')) {
            unlink(__DIR__.'/_files/TemplateRenderFixture.tpl');
            rmdir(__DIR__.'/_files');
        }
    }
}
