<?php

namespace Spec\PlanB\Utils\Builtin\Text;

use PlanB\Utils\Builtin\Text\Text;
use PlanB\Utils\Builtin\Text\Stringify;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextSpec extends ObjectBehavior
{

    const A_NAME = 'pepe botika';

    const GREETING_FORMAT = 'hello, my name is %s';
    const GREETING = 'hello, my name is pepe botika';

    public function let()
    {
        $this->beConstructedThrough('make', [self::GREETING_FORMAT, self::A_NAME]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Text::class);
        $this->shouldImplement(Stringify::class);
    }

    public function it_is_initializable_from_a_simple_string()
    {
        $this->beConstructedThrough('make', [self::A_NAME]);
        $this->shouldHaveType(Text::class);

        $this->__toString()->shouldReturn(self::A_NAME);
    }

    public function it_is_initializable_from_a_format_string()
    {
        $this->beConstructedThrough('make', [self::GREETING_FORMAT, self::A_NAME]);
        $this->shouldHaveType(Text::class);

        $this->__toString()->shouldReturn(self::GREETING);
    }

}
