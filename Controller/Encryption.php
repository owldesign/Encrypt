<?php

namespace Encrypt\Controller;

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

class Encryption
{
    /**
     * Get Secret Key
     * @return Key
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function loadEncryptionKeyFromConfig() {
        $keyAscii = file_get_contents(__DIR__ . '/key.txt');
        return Key::loadFromAsciiSafeString($keyAscii);
    }

    /**
     * Encrypt Value
     * @param null $value
     * @return string
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function encrypt($value = null) {
        if ($value == '') {
            $value = $_GET['value'];
        }
        $key = self::loadEncryptionKeyFromConfig();
        $encryptedValue = Crypto::encrypt($value, $key);

        return $encryptedValue;
    }

    /**
     * Decrypt Value
     * @param null $value
     * @return string
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function decrypt($value = null) {
        if ($value == '') {
            $value = $_GET['value'];
        }

        $key = self::loadEncryptionKeyFromConfig();

        try {
            $decryptedValue = Crypto::decrypt($value, $key);
        } catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
            $decryptedValue = 'error';
        }

        return $decryptedValue;
    }
}