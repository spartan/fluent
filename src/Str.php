<?php

namespace Spartan\Fluent;

/**
 * Str Fluent
 *
 * @package Spartan\Fluent
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Str
{
    const WITH_HEADER = true;
    const NO_HEADER   = false;

    /**
     * Convert a string to lowercase
     *
     * @param string $subject
     * @param string $encoding
     *
     * @return string
     */
    public static function lowerCase(string $subject, string $encoding = 'UTF-8'): string
    {
        return mb_strtolower($subject, $encoding);
    }

    /**
     * Convert a string to uppercase
     *
     * @param string $subject
     * @param string $encoding
     *
     * @return string
     */
    public static function upperCase(string $subject, string $encoding = 'UTF-8'): string
    {
        return mb_strtoupper($subject, $encoding);
    }

    /**
     * Capitalize words
     *
     * @param string $subject
     * @param string $encoding
     *
     * @return string
     */
    public static function titleCase(string $subject, string $encoding = 'UTF-8'): string
    {
        return mb_convert_case($subject, MB_CASE_TITLE, $encoding);
    }

    /**
     * Converts first letter of a string to lowercase
     *
     * @param string $subject
     * @param string $encoding
     *
     * @return string
     */
    public static function lowerFirst(string $subject, string $encoding = 'UTF-8'): string
    {
        if (!$subject) {
            return '';
        }

        return mb_strtolower(mb_substr($subject, 0, 1, $encoding)) . mb_substr($subject, 1, null, $encoding);
    }

    /**
     * Converts first letter of a string to uppercase
     *
     * @param string $subject
     * @param string $encoding
     *
     * @return string
     */
    public static function upperFirst(string $subject, string $encoding = 'UTF-8'): string
    {
        if (!$subject) {
            return '';
        }

        return mb_strtoupper(mb_substr($subject, 0, 1, $encoding)) . mb_substr($subject, 1, null, $encoding);
    }

    /**
     * Escape HTML
     *
     * @param string $subject
     *
     * @return string
     */
    public static function escapeHtml(string $subject): string
    {
        return htmlspecialchars($subject, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Get a slice from a string
     *
     * @param string   $subject
     * @param int      $start
     * @param int|null $length
     * @param string   $encoding
     *
     * @return string
     */
    public static function slice(
        string $subject,
        int $start = 0,
        int $length = null,
        string $encoding = 'UTF-8'
    ): string {
        return mb_substr($subject, $start, $length, $encoding);
    }

    /**
     * Truncate string
     *
     * @param string $subject
     * @param int    $length
     * @param string $separator
     * @param string $omission
     *
     * @return string
     */
    public static function truncate(
        string $subject,
        int $length = 16,
        string $separator = '',
        string $omission = '...'
    ): string {
        $subject = trim($subject);

        if (self::length($subject) <= $length) {
            return $subject;
        }

        if ($separator == '') {
            return self::slice($subject, 0, $length) . $omission;
        }

        $subject = self::slice($subject, 0, $length);
        $chars   = self::divide($separator);

        for ($i = $length - 1; $i > 0; $i--) {
            if (in_array($subject[$i], $chars)) {
                return self::slice($subject, 0, $i) . $omission;
            }
        }

        return $subject . $omission;
    }

    /**
     * Convert a string into an array of words
     *
     * @param string $subject
     * @param int    $limit
     *
     * @return array
     */
    public static function words(string $subject, int $limit = -1): array
    {
        return preg_split('/[ \.\,\:\!\?]+/', $subject, $limit, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Unicode strlen
     *
     * @param string $subject
     *
     * @return int
     */
    public static function length(string $subject): int
    {
        return mb_strlen($subject);
    }

    /**
     * Alias of strtr
     *
     * @param string $subject
     * @param array  $substitutions
     *
     * @return string
     */
    public static function replace(string $subject, array $substitutions): string
    {
        return strtr($subject, $substitutions);
    }

    /**
     * Alias of str_split
     *
     * @param string $subject
     * @param int    $length
     *
     * @return array
     */
    public static function chunks(string $subject, int $length = 1): array
    {
        return str_split($subject, $length);
    }

    /**
     * Safe split a string by a delimiter/pattern
     *
     * @param string $subject
     * @param string $pattern
     * @param int    $limit
     *
     * @return array
     */
    public static function divide(string $subject, string $pattern = '', int $limit = -1): array
    {
        return (array)preg_split('/' . preg_quote($pattern) . '/', $subject, $limit, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Generate a UUIDv4
     *
     * @see    https://stackoverflow.com/a/15875555
     *
     * @return string
     * @throws \Exception
     */
    public static function uuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Strip all characters that are non-ascii
     *
     * @param string $subject
     *
     * @return string
     */
    public static function ascii(string $subject): string
    {
        return iconv("UTF-8", "ASCII//IGNORE", $subject);
    }

    /**
     * Convert a string into a slug
     *
     * @param string $subject
     *
     * @return string
     */
    public static function slug(string $subject): string
    {
        return preg_replace(
            '/[-]+/',
            '-',
            trim(
                preg_replace(
                    '/[^a-z0-9\-]/',
                    '-',
                    transliterator_transliterate("Any-Latin; Latin-ASCII; Lower()", $subject)
                ),
                '-'
            )
        );
    }

    /**
     * Convert characters to latin
     *
     * @param string $subject
     *
     * @return string
     */
    public static function latin(string $subject): string
    {
        return transliterator_transliterate("Any-Latin; Latin-ASCII;", $subject);
    }

    /**
     * Encrypt text using sodium extension
     *
     * @param string      $subject
     * @param string|null $key
     * @param string|null $nonce
     * @param string|null $salt
     *
     * @return string
     */
    public static function encrypt(
        string $subject,
        string $salt = null,
        string $nonce = null,
        string $key = null
    ): string {
        return base64_encode(
            sodium_crypto_secretbox(
                ($salt ?: base64_decode(getenv('APP_CRYPT_SALT'))) . $subject,
                $nonce ?: base64_decode(getenv('APP_CRYPT_NONCE')),
                $key ?: base64_decode(getenv('APP_CRYPT_KEY'))
            )
        );
    }

    /**
     * Decrypt text using sodium extension
     *
     * @param string      $subject
     * @param string|null $key
     * @param string|null $nonce
     * @param string|null $salt
     *
     * @return bool|string
     * @throws \SodiumException
     */
    public static function decrypt(
        string $subject,
        string $salt = null,
        string $nonce = null,
        string $key = null
    ): string {
        return substr(
            sodium_crypto_secretbox_open(
                base64_decode($subject),
                $nonce ?: base64_decode(getenv('APP_CRYPT_NONCE')),
                $key ?: base64_decode(getenv('APP_CRYPT_KEY'))
            ),
            strlen($salt ?: base64_decode(getenv('APP_CRYPT_SALT')))
        );
    }

    /**
     * Detect writing script for the string.
     *
     * Possible responses:
     * - latin (default)
     * - cyrillic
     * - greek
     * - armenian
     * - georgian
     * - chinese
     * - japanese
     * - korean
     * - arabic
     * - hebrew
     * - indic
     *
     * @see https://en.wikipedia.org/wiki/Unicode_block
     * @see https://en.wikipedia.org/wiki/List_of_writing_systems
     *
     * @param string $subject
     *
     * @return string
     */
    public static function script(string $subject): string
    {
        $matches = [
            'Cyrillic' => 'cyrillic',
            'Greek'    => 'greek',
            'Arabic'   => 'arabic',
            'Hebrew'   => 'hebrew',
            'Armenian' => 'armenian',
            'Georgian' => 'georgian',
            'Hangul'   => 'korean',
            'Hiragana' => 'japanese',
            'Katakana' => 'japanese',
            'Han'      => 'chinese',
            'Brahmi'   => 'indic',
        ];

        foreach ($matches as $unicodeBlock => $script) {
            if (preg_match('/\p{' . $unicodeBlock . '}/u', $subject)) {
                return $script;
            }
        }

        return 'latin';
    }

    /**
     * Run xpath on xml string
     *
     * @param string $xml
     * @param string $xpath
     * @param bool   $useDomFallback
     *
     * @return \SimpleXMLElement[]|\DOMNodeList
     * @throws \Exception
     */
    public static function xpath(string $xml, string $xpath, $useDomFallback = true)
    {
        try {
            if (is_string($xml)) {
                $sxml = simplexml_load_string($xml);
                if ($sxml) {
                    return $sxml->xpath($xpath);
                }
            }
        } catch (\Exception $e) {
            if (!$useDomFallback) {
                throw $e;
            }
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($xml);
        $domPath = new \DOMXPath($dom);

        return $domPath->query($xpath);
    }

    /**
     * Use javascript notation
     *
     * @param string $subject
     * @param string $separator
     * @param int    $limit
     *
     * @return array
     */
    public static function split(string $subject, string $separator = ',', int $limit = PHP_INT_MAX)
    {
        return explode($separator, $subject, $limit);
    }

    /**
     * Generate a random string.
     *
     * @param int    $length
     * @param string $values
     *
     * @return string
     */
    public static function generate(int $length = 8, string $values = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $random = '';
        $max    = strlen($values) - 1;
        for ($i = 0; $i < $length; $i++) {
            $random .= $values[rand(0, $max)];
        }

        return $random;
    }

    /**
     * Load from csv file into an array
     *
     * @param string $path
     * @param bool   $withHeader
     *
     * @return array
     */
    public static function fromCsvFile(string $path, bool $withHeader = self::WITH_HEADER): array
    {
        $file = fopen($path, "r");

        if (!$file) {
            throw new \InvalidArgumentException("Could not open file: {$path}");
        }

        $result = [];
        $header = [];
        if ($withHeader) {
            $line   = fgets($file);
            $header = str_getcsv($line);
        }

        while (!feof($file)) {
            $line     = fgets($file);
            $result[] = $withHeader
                ? array_combine($header, str_getcsv($line))
                : str_getcsv($line);
        }
        fclose($file);

        return $result;
    }

    /**
     * Save string to a csv file
     *
     * @param string $path
     * @param array  $data
     * @param bool   $withHeader
     *
     * @return array
     */
    public static function toCsvFile(string $path, array $data, bool $withHeader = self::WITH_HEADER): array
    {
        $file = fopen($path, 'w');

        if (!$file) {
            throw new \InvalidArgumentException("Could not write to file: {$path}");
        }

        if ($withHeader && $data) {
            $header = array_keys($data[0]);
            fputcsv($file, $header);
        }

        foreach ($data as $datum) {
            fputcsv($file, $datum);
        }

        fclose($file);

        return $data;
    }
}
