<?php
/**
 * @package    Hoicoi_glosbe
 * @subpackage Base
 * @author     Jibon Lawrence Costa
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die('Restricted access'); // no direct access
$languages = explode(',',rtrim($params->get('lang'),","));
$end = end($languages);
$explo = explode("|",$end);

foreach ($languages as $language){
	$extract = explode("|", $language);
		if($explo[0] == $extract[0]){
			$selected = "selected='selected'";
		}
		if (!empty($extract[2])){
			$from .= "<option id='".$extract[0]."' value='".$extract[2]."'>".$extract[1]."</option>";
			$to .= "<option id='".$extract[0]."' value='".$extract[2]."' ".$selected.">".$extract[1]."</option>";
		}
}

require(JModuleHelper::getLayoutPath('mod_hoicoi_glosbe'));

?>