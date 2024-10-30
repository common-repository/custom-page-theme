<div class="wrap">
	  <!-- Add form validation -->
	 <script>
         jQuery(function() {
        	jQuery( '#template_name' ).keyup(function(){
				var value = jQuery(this).val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-'); 
				jQuery('#template_slug').val(value);
			});


			jQuery( "#admnPgCntntFrm" ).submit(function( event ) {
			    var reslt = true;
				var errlst = jQuery('<ul/>');
				
				
				if(jQuery('input[name="template_name"]').val() ==""){
					errlst.append("<li>Template Name is required field!</li>");
					jQuery('[name="template_name"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="template_name"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('textarea[name="template_description"]').val() == ""){
					errlst.append("<li>Template Description is required field!</li>");
					jQuery('[name="template_description"]').parent().parent().css("background-color", "#ff9999");
					jQuery('textarea[name="template_description"]').css("background-color", "#ffe5e5");
					reslt = false;
				}else {
					jQuery('[name="template_description"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="content_title"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="content_title"]').val() ) ){
					errlst.append("<li>Content Title Heading Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="content_title"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="content_title"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="container_class"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="container_class"]').val() ) ){
					errlst.append("<li>Container Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="container_class"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="container_class"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="container_id"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="container_id"]').val() ) ){
					errlst.append("<li>Container Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="container_id"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="container_id"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="commentarea_class"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="commentarea_class"]').val() ) ){
					errlst.append("<li>Comment Wrapper Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="commentarea_class"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="commentarea_class"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="commentarea_id"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="commentarea_id"]').val() ) ){
					errlst.append("<li>Comment Wrapper Id field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="commentarea_id"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="commentarea_id"]').parent().parent().css("background-color", "#cedc98");
				}
				if(reslt) return;
				
				jQuery( "#err_msg" ).html("");
				jQuery( "#err_msg" ).append(errlst).css({"background-color": "#ff9999"},{"padding": "5px"},{"font-weight":"bold"});
					
				event.preventDefault();
				//return true;
			});

         });
		 

      </script>
	<form id="admnPgCntntFrm" method="post" action="<?php echo admin_url( 'admin.php' ); ?>" enctype="multipart/form-data" >
	<h2>Page Content Template</h2><?php submit_button('Save & Preview'); ?>
	<fieldset  class="fieldst1">
   <input type="hidden" name="action" value="addpgcontent" />
    <div id="err_msg"></div>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Template Name<font>*</font></th>
		<td><span><input type="text" name="template_name" id="template_name" value="" /><span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Template Slug<font></font></th>
		<td><span><input type="text" name="template_slug" id="template_slug" value="" readonly/><span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Description<font>*</font></th>
		<td><span><textarea rows="4" cols="50" name="template_description" id="template_description"></textarea><span> </td>
		</tr>
		<tr valign="top">
		<th scope="row">Apply Content Title Heading<font></font></th>
		<td><span><select name="applytitle" id="applytitle"><option value="1">Display</option><option value="0">Hide</option></select><span> </td>
		</tr>
		<tr valign="top">
		<th scope="row">Content Title Heading Class <font></font></th>
		<td ><span  class="jscss60pernonrdr"><input type="text" name="content_title" id="content_title" value="" /></span>
		<span  class="jscss30pernobrdr">Class that you need to apply to the content title. Default 'cpt_content_title')</span></br></td></br>
		</tr>
		<tr valign="top">
		<th scope="row">Container <font></font></th>
		<td ><span  class="jscss30pernobrdr"><select name="container" id="container"><option value="div">DIV</option><option value="span">SPAN</option></select></span>
		<span>Select the html element that you need to wrap the element which forms the page content. Default 'div')</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Container Class <font></font></th>
		<td ><span  class="jscss60pernonrdr"><input type="text" name="container_class" id="container_class" value="" /></span>
		<span  class="jscss30pernobrdr">Class that you need to apply to the container element. Default 'class_cpt_container_area')</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Container Id <font></font></th>
		<td ><span  class="jscss60pernonrdr"><input type="text" name="container_id" id="container_id" value="" /></span>
		<span  class="jscss30pernobrdr">The ID that you need to apply to the container. Default 'id_cpt_content_area')</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Apply Comments<font></font></th>
		<td><span><select name="applycomments" id="applycomments"><option value="1">Display</option><option value="0">Hide</option></select><span> </td>
		</tr>
		<tr valign="top">
		<th scope="row">Comment Wrapper <font></font></th>
		<td ><span  class="jscss30pernobrdr"><select name="comment" id="comment"><option value="div">DIV</option><option value="span">SPAN</option></select></span>
		<span>Select the html element that you need to wrap the element which forms the page comments area. Default 'div')</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Comment Wrapper Class <font></font></th>
		<td ><span  class="jscss60pernonrdr"><input type="text" name="commentarea_class" id="commentarea_class" value="" /></span>
		<span  class="jscss30pernobrdr">Class that you need to apply to the container element. Default 'class_cpt_comments_area')</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Comment Wrapper Id <font></font></th>
		<td ><span  class="jscss60pernonrdr"><input type="text" name="commentarea_id" id="commentarea_id" value="" /></span>
		<span  class="jscss30pernobrdr">The ID that you need to apply to the container. Default 'id_cpt_comment_area')</span></td>
		</tr>
		
	</table>
    <?php submit_button('Save & Preview'); ?>

</fieldset>
<fieldset class="fieldst2">
	<legend>HTML Preview</legend>
	<textarea id="nav-menu-pre" rows="20" cols="80" style="border:none;text-align: left;" readonly>
		<?php 
			 echo $pg_cntnt->admin_html($attr,$attr);
		?>						 
	</textarea>
</fieldset>
</form>
