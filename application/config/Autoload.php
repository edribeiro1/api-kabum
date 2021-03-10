<?php

require_once('application/config/Config.php');

foreach (glob(APPPATH.'/services/*.php') as $file) {
    require_once $file;
}

foreach (glob(APPPATH.'/helpers/*.php') as $file) {
    require_once $file;
}

foreach (glob(APPPATH.'/core/*.php') as $file) {
    require_once $file;
}
