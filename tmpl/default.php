<?php 
/**
 * @package    Hoicoi_glosbe
 * @subpackage default
 * @author     Jibon Lawrence Costa
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access'); 
JHtml::_('jquery.framework');
JHtml::script('modules/mod_hoicoi_glosbe/assets/jquery-ui_v1.11.4.js');
JHtml::stylesheet('modules/mod_hoicoi_glosbe/assets/mod_hoicoi_glosbe.css');

?>
<script>
	jQuery("document").ready(function($){
	  $( "#tags" ).autocomplete({
		  source: function ( request, response ) {
			var textval = $("#tags").val();
			
			$.ajax({
			 url: "<?php echo JURI::base(); ?>modules/mod_hoicoi_glosbe/helper.php?textval="+textval,
			 dataType: "json",
			 method: "GET",
			success: function (data)
            {
				response(data);
            }
			});
		  }
		});
		
		$("#toggle").click(function(){
			var from = $("#selection .from").val();
		    var to = $("#selection .to").val();
	
			$("#selection .from option").prop('selected',false);
			$("#selection .to option").prop('selected',false);
			
			$("#selection .from option[value ='"+to+"']").prop('selected',true);
			$("#selection .to option[value ='"+from+"']").prop('selected',true);
		});
		
		$("#translate").click(function(){
			var phrase = $("#tags").val();
			var from = $("#selection .from").val();
		    var to = $("#selection .to").val();
			$("#meanings").html("Loading.....");
			$("#examples").html("Loading.....");
			var meanings,examples;
			$.ajax({
				url: "<?php echo JURI::base(); ?>modules/mod_hoicoi_glosbe/helper.php?phrase="+phrase+"&from="+from+"&to="+to,
				method: "GET",
				dataType: "json",			
			}).done(function(data){
				$("#meanings").html("");
				$("#examples").html("");
				$.each(data.meanings, function (k, v){
					
					$("#meanings").append(v+", ");
				})
				
				$.each(data.examples.slice(0, 5), function (k, v){
					 
					 $("#examples").append("<p>"+v+"</p>");
				})
			});
			
			
		});
			
	});
  
  </script>
 
<div class="hoicoi_glosbe<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<div class="ui-widget">
	  <label for="tags">Text: </label>
	  <input id="tags" type="text" name="textinput" value="">
	  <button id="translate" class="btn btn-primary">Translate</button>
	  <p></p>
	  <div id ="selection">From:
		<select class="from">
			<option value="eng">English</option>
			<option value="zho">Chinese</option>
		</select>
		<button id="toggle" class="btn btn-primary">Toggle</button>
		To: <select class="to">
			<option value="zho">Chinese</option>
			<option value="eng">English</option>
		</select>
	  </div>
	</div>
	<div>
		<hr>
		<p><b>Meanings:</b></p>
		<p id="meanings"></p>
	</div>
	<hr>
	<p><b>Examples: </b></p>
	<div id="examples"></div>
</div>