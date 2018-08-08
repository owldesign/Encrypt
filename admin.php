<?php

/**
 * Load Encrypt FieldType
 * Add Encryption Class
 */
$app->on('admin.init', function () {
    $this->helper('admin')->addAssets('encrypt:assets/component.js');
    $this->helper('admin')->addAssets('encrypt:assets/field-encrypt.tag');

    $this->bindClass('Encrypt\\Controller\\Encryption', 'encryption');
});

/**
 * Encrypt Value before saving to DB
 */
$app->on("collections.save.before", function($name, &$entry, $isUpdate) use ($app) {
    $collection = $app->module('collections')->collection($name);

    foreach ($collection['fields'] as $field) {
        if ($field['type'] == 'encrypt') {
            $name = $field['name'];

            if (isset($entry[$name])) {
                $entry[$name] = $app->module('encrypt')->encrypt($entry[$name]);
            }
        }
    }
});

/**
 * Decrypt Value for admin entries
 */
$app->on("collections.find.after", function($name, &$entries) use ($app) {
    $collection = $app->module('collections')->collection($name);

    foreach ($collection['fields'] as $field) {
        if ($field['type'] == 'encrypt') {
            $name = $field['name'];

            foreach ($entries as $idx => $entry) {
                if (isset($entry[$name])) {
                    $entries[$idx][$name] =  $app->module('encrypt')->decrypt($entry[$name]);
                }
            }
        }
    }
});
