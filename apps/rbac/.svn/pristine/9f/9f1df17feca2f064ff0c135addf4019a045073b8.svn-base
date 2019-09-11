<?php
// +----------------------------------------------------------------------
// | 加密/解密
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace plugin;

/**
 * <code>
 * use plugin\Crypt;
 *
 * $crypt = new Crypt();
 *
 * $text = "The message to be encrypted";
 *
 * $encrypted = $crypt->encrypt($text, $key);
 *
 * echo $crypt->decrypt($encrypted, $key);
 * </code>
 */
class Crypt
{
    const KEY = 'Oepd1OBMamXolAQXSoAetFAhwaHxXN982D';
    const IV = 'RuI1os7upxPllCqL';

    /**
     * 加密
     * @param $string 要加密的字符串
     * @return string
     */
    public static function encrypt($string)
    {
        $string = is_array($string) ? json_encode($string) : $string;

        $encrypted = openssl_encrypt($string, 'aes-256-cbc', CRYPT_KEY ?? self::KEY, OPENSSL_RAW_DATA, CRYPT_IV ?? self::IV);
        return rtrim(strtr(base64_encode($encrypted), "+/", "-_"), "=");
    }

    /**
     * 解密
     * @param $encrypt 要解密的加密串
     * @return string
     */
    public static function decrypt($encrypt)
    {
        $decrypted = base64_decode(strtr($encrypt, "-_", "+/") . substr("===", (strlen($encrypt) + 3) % 4));
        return openssl_decrypt($decrypted, 'aes-256-cbc', CRYPT_KEY ?? self::KEY, OPENSSL_RAW_DATA, CRYPT_IV ?? self::IV);
    }
}