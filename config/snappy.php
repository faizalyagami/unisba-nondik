<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */
    
    'pdf' => [
    'enabled' => true,
    'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
    'timeout' => false,
    'options' => [
        'margin-top'    => 0,
        'margin-right'  => 0,
        'margin-bottom' => 0,
        'margin-left'   => 0,
        'page-size'     => 'A4',
        'orientation'   => 'Landscape',
        'disable-smart-shrinking' => true,
        'zoom'          => 1,
        'dpi'           => 96,
        'disable-local-file-access' => false,  // penting
        'enable-local-file-access'  => true,   // untuk versi wkhtmltopdf >= 0.12.6
        'allow'         => base_path(),        // izinkan akses ke seluruh project (atau public_path())
    ],
],
    
    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTML_IMG_BINARY', '/usr/local/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
