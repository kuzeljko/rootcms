<?php

/**
 * Module of authentication module.
 * 
 * @author Aleksandra <aleksandranspasojevic@gmail.com>
 * @since Oct 2016
 */

namespace RootCmsAuth;


class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
}
