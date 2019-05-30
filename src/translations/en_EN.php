<?php

    require 'vendor/autoload.php';

    use Symfony\Component\Translation\Loader\ArrayLoader;
    use Symfony\Component\Translation\Translator;

    $t = new Translator('en_EN');
    $t->addLoader('array', new ArrayLoader());
    $t->addResource('array', [
        
    ], 'en_EN'); 
