<?php

$template = '';
$language = 'en-GB';

$template_folder = __DIR__ . '/' . $language . '/';

$template_files = array();

$temp = scandir($template_folder);

foreach ($temp as $file) {
    if ($file === '.' || $file === '..') {
    } else {
        $template_files[] = $file;
    }
}

$templates = array();

foreach ($template_files as $template_name) {

    if (file_exists($template_folder . $template_name)) {

        require $template_folder . $template_name;
        $templates[substr(
            $template_name,
            0,
            strlen($template_name) - 4
        )]
            = $template; // $template is defined in the included file

    }
}
