<?php

/**
 * This is a script to convert .pdf files to .png images.
 * Must have ghost script installed to work. 
 */
try {
    // Filepaths //
    $file = 'web_dummies.pdf';
    $destination = 'image.png';
    // Have to include string "[0]" so that it just does first page //
    $im = new Imagick($file . '[0]');
    // Setting resolution for web //
    $im->setresolution(300, 300);
    // Thumbnail image //
    $im->scaleimage(150, 150);
    // Setting new format to png //
    $im->setimageformat('png');
    // Write out image //
    $im->writeimage($destination);
    // Clear up resources and memory //
    $im->clear();
    $im->destroy();
} catch (Exception $e) {
    echo $e->getMessage();
}
