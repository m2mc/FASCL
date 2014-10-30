<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('FOS', __DIR__.'/../vendor/friendsofsymfony/user-bundle/FOS');
$loader->add('WhiteOctober', __DIR__.'/../vendor/whiteoctober/tcpdf-bundle/WhiteOctober');
$loader->add('Ensepar', __DIR__.'/../vendor/ensepar/html2pdf-bundle/Ensepar');
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
return $loader;
