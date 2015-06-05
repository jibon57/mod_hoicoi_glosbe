<?php
/**
 * @author     Jibon Lawrence Costa
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

header('Content-type: application/json');
if (!empty($_GET['textval'])){
	$url = "https://glosbe.com/ajax/phrasesAutosuggest/?from=".$_GET['from']."&dest=".$_GET['to']."&phrase=".$_GET['textval'];
	$ch =  curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$json = curl_exec($ch);
	curl_close($ch);
	echo $json;
}
		
else{
			
	$url ="https://glosbe.com/gapi/translate?from=".$_GET['from']."&dest=".$_GET['to']."&format=json&pretty=true&tm=true&phrase=".urlencode($_GET['phrase']);
	$ch =  curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	$result = curl_exec($ch);
	curl_close($ch);
	
	$data = json_decode($result, true);
	
	$meanings=array();
			
	foreach ($data['tuc'] as $key => $phrase){
		if (is_array($phrase['phrase'])){
			array_push($meanings,$phrase['phrase']['text']);
		}
		else{
			break;
		}
	}
			
	$examples = array();
			
	foreach ($data['examples'] as $example){
							
		if (is_array($example)){
								
			array_push($examples,$example['second']." (".$example['first'].")");	
							
			}
		else{
			break;
		}
							
						
	}

	$json = array(
		'meanings' => $meanings,
		'examples' => $examples
	);
	echo json_encode($json);
}