<div class="wrap">
	  <!-- Add form validation -->
	 <script>
         jQuery(function() {
        	
			jQuery( "#admnNavMenuFrm" ).submit(function( event ) {
			    var reslt = true;
				var errlst = jQuery('<ul/>');
				
				if(jQuery('input[name="menu_class"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="menu_class"]').val() ) ){
					errlst.append("<li>Menu Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="menu_class"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="menu_class"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="menu_id"]').val() !="" && /[^a-zA-Z0-9\-\\_/]/.test( jQuery('input[name="menu_id"]').val() ) ){
					errlst.append("<li>Menu Id field should be alphanumeric! Only (Special char: - and _ allowed)</li>");
					jQuery('[name="menu_id"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="menu_id"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="container_class"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="container_class"]').val() ) ){
					errlst.append("<li>Container Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="container_class"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="container_class"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="container_id"]').val() !="" && /[^a-zA-Z0-9\-\\_/]/.test( jQuery('input[name="container_id"]').val() ) ){
					errlst.append("<li>Container Id field should be alphanumeric! Only (Special char: - and _ allowed)</li>");
					jQuery('[name="container_id"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="container_id"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="link_wrapper"]').val() !="" && jQuery('input[name="link_wrapper_class"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="link_wrapper_class"]').val() ) ){
					errlst.append("<li>Link Wrapper Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="link_wrapper_class"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="link_wrapper_class"]').parent().parent().css("background-color", "#cedc98");
				}
				if(jQuery('input[name="link_txt_wrapper"]').val() !="" && /[^a-zA-Z0-9\-\\_\s/]/.test( jQuery('input[name="link_txt_wrapper_class"]').val() ) ){
					errlst.append("<li>Link Text Wrapper Class field should be alphanumeric! Only (Special char: -,_ and space allowed)</li>");
					jQuery('[name="link_txt_wrapper_class"]').parent().parent().css("background-color", "#ff9999");
					reslt = false;
				}else {
					jQuery('[name="link_txt_wrapper_class"]').parent().parent().css("background-color", "#cedc98");
				}
			
				if(reslt) return;
				
				jQuery( "#err_msg" ).html("");
				jQuery( "#err_msg" ).append(errlst).css({"background-color": "#ff9999"},{"padding": "5px"},{"font-weight":"bold"});
					
				event.preventDefault();
				//return true;

				
			});

         });
		 

      </script>
	  <?php $menu = get_term_by("id", $id,"nav_menu");
	  $nav = unserialize(get_option( "_cpt_".$menu->slug."_sch" ));
	  $atttr = array();
	  if(!empty($nav)){
		 foreach($nav as $key => $val){
			$atttr['menu'] = $nav['menu_name'];
			$atttr['menu_class'] = $nav['menu_class'];
			$atttr['menu_id'] = $nav['menu_id'];
			$atttr['container'] = $nav['container'];
			$atttr['container_class'] = $nav['container_class'];
			$atttr['container_id'] = $nav['container_id'];
			if(isset($nav['link_wrapper']) && $nav['link_wrapper'] !=''){
				$cls='';
				if(isset($nav['link_wrapper_class']) && $nav['link_wrapper_class'] !='') $cls = ' class="'.$nav['link_wrapper_class'].'"';
				$atttr['before'] = '<'.$nav['link_wrapper'].$cls.'>';
				$atttr['after'] = '</'.$nav['link_wrapper'].'>';
		    }
			if(isset($nav['link_txt_wrapper']) && $nav['link_txt_wrapper'] !=''){
				$wpcls='';
				if(isset($nav['link_txt_wrapper_class']) && $nav['link_txt_wrapper_class'] !='') $wpcls = ' class="'.$nav['link_txt_wrapper_class'].'"';
				$atttr['link_before'] =  '<'.$nav['link_txt_wrapper'].$wpcls.'>';
				$atttr['link_after'] = '</'.$nav['link_txt_wrapper'].'>';
			}
		 }
	  }
	  ?>
	  <?php function cstmpt_nav( $atts ) {
			$a = shortcode_atts( array(
				'menu'	=>	'',
				'menu_class'	=>	'',
				'menu_id'	=>	'',
				'container'	=>	'',
				'container_class'	=>	'',
				'container_id'	=>	'',
				'fallback_cb'	=>	'',
				'before'	=>	'',
				'after'	=>	'',
				'link_before'	=>	'',
				'link_after'	=>	'',
				'echo'	=>	'',
				'depth'	=>	'1',
				'theme_location' => '',
				'walker'	=>	'',
				'items_wrap'	=>	'',
				'item_spacing'	=>	'',
			), $atts );
			$nav = array();
			foreach($a as $key => $value){
				if('' != $value) $nav[$key] =  $value;
			}
			return wp_nav_menu( $nav );
		}
 ?>


	<form id="admnNavMenuFrm" method="post" action="<?php echo admin_url( 'admin.php' ); ?>" enctype="multipart/form-data" >
	<h2>Navigation Menu Customization</h2><?php submit_button('Save & Preview'); ?>
	<fieldset  class="fieldst1">
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<input type="hidden" name="menu_slug" value="<?php echo $menu->slug;?>" />
   <input type="hidden" name="action" value="custommenu" />
    <div id="err_msg"></div>
	<table class="form-table">
		<tr valign="top">
		<th scope="row" colspan="2">Menu <font>((readonly) field indicates selected menu Name or Slug)</font>
		</br><span><input type="text" name="menu_name" value="<?php echo $menu->name; ?>" readonly/><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Menu Class <font>((string) CSS class that you need to apply over ul element which forms the menu. Default 'menu')</font>
		</br><span><input type="text" name="menu_class" id="menu_class" value="" /><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Menu Id <font>((string) The ID that that you need to apply to the ul element which forms the menu. Default is the menu slug, incremented)</font>
		</br><span><input type="text" name="menu_id" id="menu_id" value="" /><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Container <font>((readonly) Select the html element that you need to wrap the ul element which forms the menu. Default 'div')</font>
		</br><span><select name="container" id="container" readonly><option value="div">DIV</option></select><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Container Class <font>((string) Class that you need to apply to the container element. Default 'menu-{menu slug}-container')</font>
		</br><span><input type="text" name="container_class" id="container_class" value="<?php echo $menu->container_class; ?>" /><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Container Id <font>((string) The ID that you need to apply to the container.)</font>
		</br><span><input type="text" name="container_id" id="container_id" value="<?php echo $menu->container_id; ?>" /><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Link Wrapper <font>((string) Select the html element that you need to wrap the each link element which forms the menu items.)</font>
		</br><span><select name="link_wrapper" id="link_wrapper"><option value="">Default</option><option value="div">DIV</option><option value="span">SPAN</option></select><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Link Wrapper Class <font>((string) Class that you need to apply to the Wrapper of link element.)</font>
		</br><span><input type="text" name="link_wrapper_class" id="link_wrapper_class" value="" /><span></th>
		</tr>

		<th scope="row" colspan="2">Link Text Wrapper <font>((string) Select the html element that you need to wrap the text inside each link element which forms the menu items.)</font>
		</br><span><select name="link_txt_wrapper" id="link_txt_wrapper"><option value="">Default</option><option value="div">DIV</option><option value="span">SPAN</option></select><span></th>
		</tr>
		<tr valign="top">
		<th scope="row" colspan="2">Link Text Wrapper Class <font>((string) Class that you need to apply to the Wrapper of text inside link.)</font>
		</br><span><input type="text" name="link_txt_wrapper_class" id="link_txt_wrapper_class" value="" /><span></th>
		</tr>

	</table>
    <?php submit_button('Save & Preview'); ?>

</fieldset>
<fieldset class="fieldst2">
	<legend>Preview</legend>
	<textarea id="nav-menu-pre" rows="20" cols="80" style="border:none;text-align: left;" readonly>
		<?php echo cstmpt_nav( $atttr );  ?>						 
	</textarea>
</fieldset>
</form>
<?php
if(!empty($nav)){
echo '<script type="text/javascript">';
echo 'jQuery(document).ready(function() {';
foreach($nav as $key => $val){
echo 'jQuery("#'.$key.'").val("'.$val.'");';
}
echo '});';
echo '</script>';
}
?>
