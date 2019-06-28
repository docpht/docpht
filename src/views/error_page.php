<?php

/**
 * This file is part of the DocPHT project.
 * 
 * @author Valentino Pesce
 * @copyright (c) Valentino Pesce <valentino@iltuobrand.it>
 * @copyright (c) Craig Crosby <creecros@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>


    <div class="jumbotron text-center fade-in-fwd">
            <b>404</b>
            <h1><?= $t->trans('I\'m sorry, friend!'); ?></h1> 
            <p><?= $t->trans('I can\'t find this page anymore or the administrator doesn\'t want you to see it!'); ?></p> 
            ​<picture>
                    <source srcset="public/assets/img/404.svg" type="image/svg+xml">
                    <img src="public/assets/img/404.svg" width="300" class="img-fluid" alt="404">
            </picture>
            <p><a href="<?= BASE_URL ?>"><?= $t->trans('Don\'t despair, you can always click here'); ?></a></p>
            <small><b><?= $t->trans('With sympathy from DocPHT'); ?> <i class="fa fa-code" aria-hidden="true"></i></b></small>
    </div>


