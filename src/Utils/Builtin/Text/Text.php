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
     * @param \PlanB\Utils\Builtin\Text\Encoding|null $encoding
     */
    private function __construct(string $text, ?Encoding $encoding = null)
    {

        $this->text = $text;
        $this->encoding = Encoding::safeValue($encoding);
    }

    /**
     * Crea una instancia, con un encoding distinto al interno
     *
     * @param string $text
     * @param \PlanB\Utils\Builtin\Text\Encoding $encoding
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public static function makeEncoded(string $text, Encoding $encoding): Text
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
     * @param \PlanB\Utils\Builtin\Text\Encoding $newEncoding : El nuevo encoding
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function changeEncoding(Encoding $newEncoding): Text
    {
        $currentEncoding = Encoding::get($this->encoding);

        if ($newEncoding->is($currentEncoding)) {
            return new self($this->text, $currentEncoding);
        }

        $newText = mb_convert_encoding($this->text, (string) $newEncoding, (string) $currentEncoding);

        return new self($newText, $newEncoding);
    }

    /**
     * Devuelve la longitud del texto
     *
     * @return int
     */
    public function getLength(): int
    {
        return mb_strlen($this->text, $this->encoding);
    }
}
