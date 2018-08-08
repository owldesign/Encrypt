<?php

/**
 * Load vendor library
 */
include(__DIR__.'/vendor/autoload.php');

use Encrypt\Controller\Encryption;
/**
 * Extend modules
 */
$this->module('encrypt')->extend([
    'encrypt' => function($value) {
        $encrypted = Encryption::encrypt($value);

        return $encrypted;
    },
    'decrypt' => function($value) {
        $decrypted = Encryption::decrypt($value);

        return $decrypted;
    }
]);

/**
 * Include admin.php
 */
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
    include_once __DIR__ . '/admin.php';
}

/**
 * Actions for REST API
 */
if (COCKPIT_API_REQUEST) {
    include_once __DIR__ . '/actions.php';
}