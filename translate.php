<?php

function parseItem(&$data, $item)
{
    foreach ($item as $translationKey => $translationValue) {
        if (is_array($translationValue)) {
            if (empty($data[$translationKey])) {
                $data[$translationKey] = [];
            }

            parseItem($data[$translationKey], $translationValue);
            continue;
        }


        if (empty($data[$translationKey])) {
            $data[$translationKey] = "$translationValue MISSING_TRANSLATION";
        }
    }
}

$data = file_get_contents('translations.json');
$decoded = json_decode($data, true);
echo PHP_EOL;
foreach ($decoded['en'] as $key => $item) {
    if (empty($decoded['pl'][$key])) {
        $decoded['pl'][$key] = [];
    }

    parseItem($decoded['pl'][$key], $item);
}

$encoded = json_encode($decoded, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
file_put_contents('translations-fixed.json', $encoded);
echo 'Generowanie zakończone';

