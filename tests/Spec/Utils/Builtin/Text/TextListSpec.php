<?php

namespace Spec\PlanB\Utils\Builtin\Text;

use PlanB\Utils\Builtin\Text\Text;
use PlanB\Utils\Builtin\Text\TextList;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextListSpec extends ObjectBehavior
{


    private function make(string ...$params): self
    {
        $this->beConstructedThrough('make', $params);
        return $this;
    }

    public function it_is_initializable()
    {
        $this->make();

        $this->shouldHaveType(TextList::class);
        $this->shouldHaveType(\IteratorAggregate::class);
        $this->shouldHaveType(\Countable::class);
    }

    public function it_identifies_an_empty_list()
    {
        $this->make(...[]);

        $this->count()->shouldReturn(0);
        $this->isEmpty()->shouldReturn(true);
    }

    public function it_is_initializable_with_elements()
    {
        $this->make('hola', 'mi', 'nombre', 'es', 'pepe');

        $this->count()->shouldReturn(5);
        $this->isEmpty()->shouldReturn(false);
    }


    public function it_can_join_to_an_unique_text_object()
    {
        $this->make('hola', 'mi', 'nombre', 'es', 'pepe');

        $this->join('-')
            ->__toString()
            ->shouldReturn('hola-mi-nombre-es-pepe');
    }

}
