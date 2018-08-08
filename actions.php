<?php

/**
 * Decrypt Value for Rest API
 */
$app->on('collections.find.after', function ($name, &$entries) use ($app) {
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