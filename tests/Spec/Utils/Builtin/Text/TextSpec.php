<?php

namespace Spec\PlanB\Utils\Builtin\Text;

use PlanB\Utils\Builtin\Text\Encoding;
use PlanB\Utils\Builtin\Text\Text;
use PlanB\Utils\Builtin\Text\Stringify;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextSpec extends ObjectBehavior
{

    const A_NAME = 'josé botika';
    const A_UTF_7_NAME = 'jos+AOk botika';

    const GREETING_FORMAT = 'hello, my name is %s';
    const GREETING = 'hello, my name is josé botika';
    const GREETING_LENGTH = 29;


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

    public function it_has_the_internal_encoding_by_default()
    {
        $this->beConstructedThrough('make', [self::GREETING_FORMAT, self::A_NAME]);
        $this->getEncoding()->shouldReturn(mb_internal_encoding());
    }

    public function it_is_initializable_with_a_specific_encoding()
    {

        $this->beConstructedThrough('makeEncoded', [self::A_UTF_7_NAME, Encoding::UTF_7()]);
        $this->shouldHaveType(Text::class);

        $this->__toString()->shouldReturn(self::A_UTF_7_NAME);
    }

    public function it_can_change_the_encoding()
    {
        $this->beConstructedThrough('makeEncoded', [self::A_UTF_7_NAME, Encoding::UTF_7()]);

        $this->changeEncoding(Encoding::UTF_8())
            ->__toString()->shouldReturn(self::A_NAME);
    }

    public function it_do_nothing_if_the_new_encoding_if_the_equal_to_current()
    {
        $this->beConstructedThrough('makeEncoded', [self::A_UTF_7_NAME, Encoding::UTF_7()]);

        $this->changeEncoding(Encoding::UTF_7())
            ->__toString()->shouldReturn(self::A_UTF_7_NAME);
    }


    public function it_can_retrieve_the_length_of_a_text()
    {
        $this->beConstructedThrough('make', [self::GREETING_FORMAT, self::A_NAME]);

        $this->getLength()->shouldReturn(self::GREETING_LENGTH);
    }

    public function it_can_retrieve_the_length_of_an_encoded_text()
    {

        $text = sprintf(self::GREETING_FORMAT, self::A_UTF_7_NAME);
        $this->beConstructedThrough('makeEncoded', [$text, Encoding::UTF_7()]);

        $this->getLength()->shouldReturn(self::GREETING_LENGTH);
    }

    public function it_identifies_an_empty_text()
    {
        $this->beConstructedThrough('make', [Text::EMPTY]);
        $this->isEmpty()->shouldReturn(true);
        $this->isBlank()->shouldReturn(true);
    }

    public function it_identifies_a_blank_text()
    {
        $this->beConstructedThrough('make', [Text::SPACE]);
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(true);
    }

    public function it_identifies_a_printable_text()
    {
        $this->beConstructedThrough('make', [self::GREETING]);
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(false);
    }

    public function it_identifies_a_tab_char()
    {
        $this->beConstructedThrough('make', ["\t"]);
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(true);
    }

    public function it_identifies_a_new_line_char()
    {
        $this->beConstructedThrough('make', ["\n"]);
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(true);
    }

}
