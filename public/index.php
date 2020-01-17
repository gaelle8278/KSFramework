<?php
require __DIR__.'/../lib/KSFram/SplClassLoader.php';

//auto-loading
$KSFramLoader = new SplClassLoader('KSFram', __DIR__.'/../lib');
$KSFramLoader->register();

echo "toto";