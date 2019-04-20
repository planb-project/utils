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

use MabeEnum\Enum;

/**
 * Enum con los tipos de enconding soportados por php
 *
 * @see https://www.php.net/manual/es/mbstring.supported-encodings.php
 *
 * @method static Encoding PASS
 * @method static Encoding AUTO
 * @method static Encoding WCHAR
 * @method static Encoding BYTE2BE
 * @method static Encoding BYTE2LE
 * @method static Encoding BYTE4BE
 * @method static Encoding BYTE4LE
 * @method static Encoding BASE64
 * @method static Encoding UUENCODE
 * @method static Encoding HTML_ENTITIES
 * @method static Encoding QUOTED_PRINTABLE
 * @method static Encoding BIT7
 * @method static Encoding BIT8
 * @method static Encoding UCS_4
 * @method static Encoding UCS_4BE
 * @method static Encoding UCS_4LE
 * @method static Encoding UCS_2
 * @method static Encoding UCS_2BE
 * @method static Encoding UCS_2LE
 * @method static Encoding UTF_32
 * @method static Encoding UTF_32BE
 * @method static Encoding UTF_32LE
 * @method static Encoding UTF_16
 * @method static Encoding UTF_16BE
 * @method static Encoding UTF_16LE
 * @method static Encoding UTF_8
 * @method static Encoding UTF_7
 * @method static Encoding UTF7_IMAP
 * @method static Encoding ASCII
 * @method static Encoding EUC_JP
 * @method static Encoding SJIS
 * @method static Encoding EUCJP_WIN
 * @method static Encoding EUC_JP_2004
 * @method static Encoding SJIS_WIN
 * @method static Encoding SJIS_MOBILE_DOCOMO
 * @method static Encoding SJIS_MOBILE_KDDI
 * @method static Encoding SJIS_MOBILE_SOFTBANK
 * @method static Encoding SJIS_MAC
 * @method static Encoding SJIS_2004
 * @method static Encoding UTF_8_MOBILE_DOCOMO
 * @method static Encoding UTF_8_MOBILE_KDDI_A
 * @method static Encoding UTF_8_MOBILE_KDDI_B
 * @method static Encoding UTF_8_MOBILE_SOFTBANK
 * @method static Encoding CP932
 * @method static Encoding CP51932
 * @method static Encoding JIS
 * @method static Encoding ISO_2022_JP
 * @method static Encoding ISO_2022_JP_MS
 * @method static Encoding GB18030
 * @method static Encoding WINDOWS_1252
 * @method static Encoding WINDOWS_1254
 * @method static Encoding ISO_8859_1
 * @method static Encoding ISO_8859_2
 * @method static Encoding ISO_8859_3
 * @method static Encoding ISO_8859_4
 * @method static Encoding ISO_8859_5
 * @method static Encoding ISO_8859_6
 * @method static Encoding ISO_8859_7
 * @method static Encoding ISO_8859_8
 * @method static Encoding ISO_8859_9
 * @method static Encoding ISO_8859_10
 * @method static Encoding ISO_8859_13
 * @method static Encoding ISO_8859_14
 * @method static Encoding ISO_8859_15
 * @method static Encoding ISO_8859_16
 * @method static Encoding EUC_CN
 * @method static Encoding CP936
 * @method static Encoding HZ
 * @method static Encoding EUC_TW
 * @method static Encoding BIG_5
 * @method static Encoding CP950
 * @method static Encoding EUC_KR
 * @method static Encoding UHC
 * @method static Encoding ISO_2022_KR
 * @method static Encoding WINDOWS_1251
 * @method static Encoding CP866
 * @method static Encoding KOI8_R
 * @method static Encoding KOI8_U
 * @method static Encoding ARMSCII_8
 * @method static Encoding CP850
 * @method static Encoding JIS_MS
 * @method static Encoding ISO_2022_JP_2004
 * @method static Encoding ISO_2022_JP_MOBILE_KDDI
 * @method static Encoding CP50220
 * @method static Encoding CP50220RAW
 * @method static Encoding CP50221
 * @method static Encoding CP50222
 */
final class Encoding extends Enum implements Stringify
{
    public const PASS = 'pass';
    public const AUTO = 'auto';
    public const WCHAR = 'wchar';
    public const BYTE2BE = 'byte2be';
    public const BYTE2LE = 'byte2le';
    public const BYTE4BE = 'byte4be';
    public const BYTE4LE = 'byte4le';
    public const BASE64 = 'BASE64';
    public const UUENCODE = 'UUENCODE';
    public const HTML_ENTITIES = 'HTML-ENTITIES';
    public const QUOTED_PRINTABLE = 'Quoted-Printable';
    public const BIT7 = '7bit';
    public const BIT8 = '8bit';
    public const UCS_4 = 'UCS-4';
    public const UCS_4BE = 'UCS-4BE';
    public const UCS_4LE = 'UCS-4LE';
    public const UCS_2 = 'UCS-2';
    public const UCS_2BE = 'UCS-2BE';
    public const UCS_2LE = 'UCS-2LE';
    public const UTF_32 = 'UTF-32';
    public const UTF_32BE = 'UTF-32BE';
    public const UTF_32LE = 'UTF-32LE';
    public const UTF_16 = 'UTF-16';
    public const UTF_16BE = 'UTF-16BE';
    public const UTF_16LE = 'UTF-16LE';
    public const UTF_8 = 'UTF-8';
    public const UTF_7 = 'UTF-7';
    public const UTF7_IMAP = 'UTF7-IMAP';
    public const ASCII = 'ASCII';
    public const EUC_JP = 'EUC-JP';
    public const SJIS = 'SJIS';
    public const EUCJP_WIN = 'eucJP-win';
    public const EUC_JP_2004 = 'EUC-JP-2004';
    public const SJIS_WIN = 'SJIS-win';
    public const SJIS_MOBILE_DOCOMO = 'SJIS-Mobile#DOCOMO';
    public const SJIS_MOBILE_KDDI = 'SJIS-Mobile#KDDI';
    public const SJIS_MOBILE_SOFTBANK = 'SJIS-Mobile#SOFTBANK';
    public const SJIS_MAC = 'SJIS-mac';
    public const SJIS_2004 = 'SJIS-2004';
    public const UTF_8_MOBILE_DOCOMO = 'UTF-8-Mobile#DOCOMO';
    public const UTF_8_MOBILE_KDDI_A = 'UTF-8-Mobile#KDDI-A';
    public const UTF_8_MOBILE_KDDI_B = 'UTF-8-Mobile#KDDI-B';
    public const UTF_8_MOBILE_SOFTBANK = 'UTF-8-Mobile#SOFTBANK';
    public const CP932 = 'CP932';
    public const CP51932 = 'CP51932';
    public const JIS = 'JIS';
    public const ISO_2022_JP = 'ISO-2022-JP';
    public const ISO_2022_JP_MS = 'ISO-2022-JP-MS';
    public const GB18030 = 'GB18030';
    public const WINDOWS_1252 = 'Windows-1252';
    public const WINDOWS_1254 = 'Windows-1254';
    public const ISO_8859_1 = 'ISO-8859-1';
    public const ISO_8859_2 = 'ISO-8859-2';
    public const ISO_8859_3 = 'ISO-8859-3';
    public const ISO_8859_4 = 'ISO-8859-4';
    public const ISO_8859_5 = 'ISO-8859-5';
    public const ISO_8859_6 = 'ISO-8859-6';
    public const ISO_8859_7 = 'ISO-8859-7';
    public const ISO_8859_8 = 'ISO-8859-8';
    public const ISO_8859_9 = 'ISO-8859-9';
    public const ISO_8859_10 = 'ISO-8859-10';
    public const ISO_8859_13 = 'ISO-8859-13';
    public const ISO_8859_14 = 'ISO-8859-14';
    public const ISO_8859_15 = 'ISO-8859-15';
    public const ISO_8859_16 = 'ISO-8859-16';
    public const EUC_CN = 'EUC-CN';
    public const CP936 = 'CP936';
    public const HZ = 'HZ';
    public const EUC_TW = 'EUC-TW';
    public const BIG_5 = 'BIG-5';
    public const CP950 = 'CP950';
    public const EUC_KR = 'EUC-KR';
    public const UHC = 'UHC';
    public const ISO_2022_KR = 'ISO-2022-KR';
    public const WINDOWS_1251 = 'Windows-1251';
    public const CP866 = 'CP866';
    public const KOI8_R = 'KOI8-R';
    public const KOI8_U = 'KOI8-U';
    public const ARMSCII_8 = 'ArmSCII-8';
    public const CP850 = 'CP850';
    public const JIS_MS = 'JIS-ms';
    public const ISO_2022_JP_2004 = 'ISO-2022-JP-2004';
    public const ISO_2022_JP_MOBILE_KDDI = 'ISO-2022-JP-MOBILE#KDDI';
    public const CP50220 = 'CP50220';
    public const CP50220RAW = 'CP50220raw';
    public const CP50221 = 'CP50221';
    public const CP50222 = 'CP50222';

    /**
     * Devuelve el valor de un encoding
     * Si no se especifica ninguno, se devuelve el encoding internal
     *
     * @param \PlanB\Utils\Builtin\Text\Encoding|string|null $encoding
     *
     * @return string
     */
    public static function safeValue($encoding = null): string
    {
        if (is_null($encoding)) {
            return \mb_internal_encoding();
        }

        $encoding = Encoding::get($encoding);

        return $encoding->getValue();
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getValue();
    }
}
