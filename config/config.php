<?php

/**
 * PHP version 5
 * @copyright  Jan Theofel 2012-2013, ETES GmbH 2009
 * @author     Jan Theofel <jan@theofel.de>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id: config.php 19 2012-10-27 19:57:11Z jan $
 */


$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array('InputCount', 'injectJavascriptBE');
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('InputCount', 'injectJavascriptFE');

