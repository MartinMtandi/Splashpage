<?php
// Instantiate new DOMDocument object
$svg = new DOMDocument();
// Load SVG file from public folder
$svg->load(public_path('img/preloader/pendelum.svg'));
// Echo XML without version element
echo $svg->saveXML($svg->documentElement);
?>