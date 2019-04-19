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

namespace PlanB\Utils\Builtin\Text;

/**
 * Wrapper para cadenas de texto
 */
class Text implements Stringify
{
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $encoding;

    /**
     * Text constructor.
     *
     * @param string $text
     * @param string|null $encoding
     */
    private function __construct(string $text, ?string $encoding = null)
    {
        $this->text = $text;
        $this->encoding = $encoding ?? mb_internal_encoding();
    }

    /**
     * Crea una instancia, con un encoding distinto al interno
     *
     * @param string $text
     * @param string $encoding
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public static function makeEncoded(string $text, string $encoding): Text
    {
        return new self($text, $encoding);
    }

    /**
     * Crea una nueva instancia
     *
     * @param string $format
     * @param mixed ...$params
     *
     * @return \PlanB\Utils\Builtin\Text
     */
    public static function make(string $format, ...$params): Text
    {
        $text = sprintf($format, ...$params);

        return new self($text);
    }


    /**
     * @inheritdoc
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->text;
    }

    /**
     * Devuelve el encoding
     *
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * Cambia el encoding del texto
     *
     * @param string $newEncoding : El nuevo encoding
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function changeEncoding(string $newEncoding): Text
    {
        if (0 === strcasecmp($newEncoding, $this->encoding)) {
            return new self($this->text, $this->encoding);
        }

        $newText = mb_convert_encoding($this->text, $newEncoding, $this->encoding);

        return new self($newText, $newEncoding);
    }
}
