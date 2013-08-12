<?php

/**
 * PHP version 5
 * @copyright  Jan Theofel 2012-2013, ETES GmbH 2010
 * @author     Jan Theofel <jan@theofel.de>, Andreas Schempp <andreas@schempp.ch>, Marc Schneider <marc.schneider@etes.de>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

$GLOBALS['TL_CONFIG']['inputcount'][] = 'tl_page.description';
$GLOBALS['TL_DCA']['tl_page']['fields']['description']['eval']['maxlength'] = 200;
