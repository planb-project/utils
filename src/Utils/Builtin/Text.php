<?php

/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PlanB\Utils\Builtin;

/**
 * Wrapper para cadenas de texto
 */
class Text
{
    /**
     * @var string
     */
    private $text;

    /**
     * Text constructor.
     *
     * @param string $text
     */
    private function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Crea una nueva instancia
     *
     * @param string $format
     * @param mixed  ...$params
     *
     * @return \PlanB\Utils\Builtin\Text
     */
    public static function make(string $format, ...$params): Text
    {
        $text = sprintf($format, ...$params);

        return new Text($text);
    }


    /**
     * Devuelve la cadena de texto
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->text;
    }
}
