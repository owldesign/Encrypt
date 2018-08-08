<?php

namespace Encrypt\Controller;

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;
use Lime\App;

class Encryption
{
    static public $app;

    function __construct() {
        static::$app = App::instance('Cockpit');
    }

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
     * @return string
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public function encrypt() {
        $value = $this->app->param('value');

        if ($value == '') {
            $value = $_GET['value'];
        }

        $key = self::loadEncryptionKeyFromConfig();
        $encryptedValue = Crypto::encrypt($value, $key);

        return $encryptedValue;
    }

    /**
     * Decrypt Value
     * @return string
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function decrypt() {
        $post = (static::$app->param('value') != '') ? true : false;
        $get = isset($_GET['value']) ? true : false;

        if ($post) {
            return json_encode(self::_decrypt(static::$app->param('value')));
        }

        if ($get) {
            return self::_decrypt($_GET['value']);
        }
    }

    /**
     * Encrypt REST
     * @param $value
     * @return string
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function encryptRest($value) {
        $key = self::loadEncryptionKeyFromConfig();
        $encryptedValue = Crypto::encrypt($value, $key);
        return $encryptedValue;
    }

    /**
     * Decrypt REST
     * @param $value
     * @return string
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function decryptRest($value) {
        return self::_decrypt($value);
    }

    /**
     * Decrypting Value
     * @param $value
     * @return string
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    private static function _decrypt($value) {
        $key = self::loadEncryptionKeyFromConfig();

        try {
            $decryptedValue = Crypto::decrypt($value, $key);
        } catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
            $decryptedValue = 'error';
        }

        return $decryptedValue;
    }
}