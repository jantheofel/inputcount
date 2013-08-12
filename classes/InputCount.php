<?php

/**
 * PHP version 5
 * @copyright  Jan Theofel 2012-2013, ETES GmbH 2009
 * @author     Jan Theofel <jan@theofel.de>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id: InputCount.php 18 2012-10-27 19:51:29Z jan $
 */

namespace Contao;

class InputCount extends \Frontend
{	
	private function injectCode ($strBuffer, $strJS, $html5syntax)
	{
		if($strJS != '')
		{
			$inner = $strJS;
			if($html5syntax)
			{
				$strJS = '
<script>';				
			}
			else
			{
				$strJS = '
<script type="text/javascript">
/* <![CDATA[ */';
			}
			
			$strJS .= '
(function($){
var IC = new InputCount();
window.addEvent(\'domready\', function()
{'.$inner.'
});
window.addEvent(\'subpalette\', function()
{'.$inner.'
});
})(document.id);
';

			if(!$html5syntax)
			{
				$strJS .= '
/* ]]> */';				
			}
		
			$strJS .= '
</script>
</body>';

			$strBuffer = str_replace('</body>', $strJS, $strBuffer);
			$head = '
<link rel="stylesheet" href="system/modules/inputcount/assets/inputcount.css" type="text/css" media="screen" />
<script type="text/javascript" src="system/modules/inputcount/assets/inputcount.js"></script>
</head>
';
			$strBuffer = str_replace('</head>', $head, $strBuffer);
		}
		return $strBuffer;
	}

	private function injectField($intLength, $msg, $formular, $field)
	{
		if (strlen($msg))
			$strMessage = sprintf($msg, "' + event.target.value.length +'");
		else
			$strMessage = sprintf($GLOBALS['TL_LANG']['MSC']['inputcount'], "' + event.target.value.length +'");
	
		if($intLength > 0)
		{
			$strJS .= "\n	$$('#" . $formular . " #" . $field . "').addEvent('focus', function(event) { IC.showMessage(event.target, '" . $strMessage . "', '".$intLength."'); }).addEvent('keyup', function(event) { IC.showMessage(event.target, '" . $strMessage . "', '".$intLength."'); }).addEvent('blur', function(event) { IC.hideMessage(event.target); });";
		}
		else
		{
			$strJS .= "\n   $$('#" . $formular . " #" . $field . "').addEvent('focus', function(event) { IC.showMessage(event.target, '" . $strMessage . "'); }).addEvent('keyup', function(event) { IC.showMessage(event.target, '" . $strMessage . "'); }).addEvent('blur', function(event) { IC.hideMessage(event.target); });";
		}
		return $strJS;
	}

	public function injectJavascript($strBuffer)
	{
		// this function avoids warnings while updating to 1.4.x
		return $strBuffer;
	}

	public function injectJavascriptBE($strBuffer)
	{
		// only needed on pages in edit mode
		if ($this->Input->get('act') != 'edit')
			return $strBuffer;
		if (!is_array($GLOBALS['TL_CONFIG']['inputcount']))
			return $strBuffer;

		foreach( $GLOBALS['TL_CONFIG']['inputcount'] as $strField )
		{
			$arrField = preg_split('/\./', $strField);
			
			if(preg_match('/<form[^>]+id="' . $arrField[0] . '"/', $strBuffer))
			{
				$strJS .= $this->injectField(
					intval($GLOBALS['TL_DCA'][$arrField[0]]['fields'][$arrField[1]]['eval']['maxlength']),
					$GLOBALS['TL_LANG']['MSC'][$strField],
					$arrField[0], "ctrl_" . $arrField[1]);
			}
		}
			
		return $this->injectCode($strBuffer, $strJS, 1);
	}

	public function injectJavascriptFE($strBuffer, $strTemplate)
	{
		global $objPage;
		if (!is_array($GLOBALS['INPUTCOUNT']))
			return $strBuffer;

		foreach( array_keys($GLOBALS['INPUTCOUNT']) as $formular )
		{
			if(preg_match('/<form[^>]+id="' . $formular . '"/', $strBuffer))
			{
				foreach( array_keys($GLOBALS['INPUTCOUNT'][$formular]) as $field )
				{
					if(preg_match('/<(input|textarea|select)[^>]+id="' . $field . '"/', $strBuffer))
					{
						$strJS .= $this->injectField(
							intval($GLOBALS['INPUTCOUNT'][$formular][$field]['maxlength']),
							$GLOBALS['INPUTCOUNT'][$formular][$field]['message'],
							$formular, $field);
					}
				}
			}
		}

		return $this->injectCode($strBuffer, $strJS, ($objPage->outputFormat == 'html5'));
	}

}
