<?php

/**
 * This file is part of the planb project.
 *
 * (c) jmpantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PlanB\Utils\Builtin;

/**
 * Define la interfaz Stringify
 *
 * Objetos que pueden ser convertidos a una cadena de texto
 */
interface Stringify
{
    /**
     * Devuelve la cadena de texto
     *
     * @see https://secure.php.net/language.oop5.magic#object.tostring
     *
     * @return string
     */
    public function __toString(): string;
}
