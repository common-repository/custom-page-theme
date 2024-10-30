  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.html">Custom<span class="logo_colour">PageTheme</span></a></h1>
          <h2>A Sample Theme To Get Start With.</h2>
        </div>
      </div>
	  	  <?php echo do_shortcode("[custom_page_theme_nav menu=\"cpt-sample-menu\"]"); ?>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
      <div id="banner"></div>
	  <div id="sidebar_container">
		<div class="sidebar">
          <div class="sidebar_top"></div>
          <div class="sidebar_item">
			<?php echo do_shortcode("[custom_page_theme_search_widget]"); ?>
          </div>
          <div class="sidebar_base"></div>
        </div>
		<div class="sidebar">
          <div class="sidebar_top"></div>
          <div class="sidebar_item">
			<?php echo do_shortcode("[custom_page_theme_calendar_widget]"); ?>
          </div>
          <div class="sidebar_base"></div>
        </div>
      </div>
      <div id="content">
        <!-- insert the page content here -->
		<?php if($post) echo do_shortcode("[custom_page_theme_page_content_widget]"); ?>
			<div id="tab2cnt">
				<h2>Installation & Activation</h2>
				<p></p>
				<ol>
				  <li>Download the CUSTOM PAGE THEME Plugin <a href="https://wordpress.org/plugins/custom-page-theme/" target="blank">DOWNLOAD PLUGIN</a>.<img src="<?php echo plugins_url().'/custom-page-theme/img/plugin_instal.png' ?>" width="400px" /></li>
				  <li>Instal the Plugin and Activate then.</li>
				  <li>It adds a menu <i>Custom Page Theme</i> in Left Navigation bar.<img src="<?php echo plugins_url().'/custom-page-theme/img/plugin_handler.png' ?>" width="100px" /></li>
				</ol>
				<h3>With Version 10.0.3, The Plugin offers a sample theme that you can follow to make your own Custom Page Themes. </p>
				<h2>First Sample Theme</h3>
				<ol>
					<li>In Left Navigation Menu Click on <i>Custom Page Theme -> Add Theme</i> And Open Add New Theme form.<img src="<?php echo plugins_url().'/custom-page-theme/img/add_theme_frm.png' ?>" width="700px" /> </li>
				</ol>
			</div>
			<div id="tab3cnt">
					<p><strong>Custom Page Theme</strong> helps you to draw various WordPress elements and widgets on you web template, without any programming intervention. You just copy the shortcodes and paste them on right place & Let <strong>Custom Page Theme</strong> take the charge.</p>
					<h2>Navigation Menu</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_nav menu=\&#34;menu-name\&#34;]&#34;); &#63;&gt;</p>
					<span class="left">Sample: <?php echo do_shortcode("[custom_page_theme_nav menu=\"cpt-sample-menu\"]"); ?></span>
					<p>
					  <i>custom_page_theme_nav</i> is a shortcode that will draw the navigation menu in ul/li format. The attribute <i>menu</i> defines the name or slug of the menu that you want to draw.
					</p>
					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Page Content Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_page_content_widget]&#34;); &#63;&gt;</p>
					<p>
					   <i>custom_page_theme_page_content_widget</i> is a shortcode to draw the WordPress driven Page Content Widget. The Layout of Page Content Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>


					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Search Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_search_widget]&#34;); &#63;&gt;</p>
					<span class="left">Sample: <?php echo do_shortcode("[custom_page_theme_search_widget]"); ?></span>
					<p>
					  <i>custom_page_theme_search_widget</i> is a shortcode to draw the a WordPress Search form. The Search Form Layout is always same that WordPress  offers as default, But you can style it's Layout by your styling skills.
					</p>
					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Calendar Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_calendar_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_calendar_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_calendar_widget</i> is a shortcode to draw the WordPress driven Calendar. The Layout of Calendar is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>
					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Categories Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_categories_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_categories_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_categories_widget</i> is a shortcode to draw the WordPress driven Categories Widget. The Layout of Categories Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>

					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Links Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_links_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_links_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_links_widget</i> is a shortcode to draw the WordPress driven Links Widget. The Layout of Link Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>

					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Meta Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_meta_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_meta_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_meta_widget</i> is a shortcode to draw the WordPress driven Meta Widget. The Layout of Meta Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>

					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Pages Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_pages_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_pages_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_pages_widget</i> is a shortcode to draw the WordPress driven Pages Widget. The Layout of Pages Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>

					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Resent Comments Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_resent_comments_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_resent_comments_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_resent_comments_widget</i> is a shortcode to draw the WordPress driven Resent Comments Widget. The Layout of Resent Comments Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>
					
					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Resent Posts Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_recent_posts_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_recent_posts_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_recent_posts_widget</i> is a shortcode to draw the WordPress driven Resent Posts Widget. The Layout of Resent Posts Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>

					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>RSS Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_rss_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_rss_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_rss_widget</i> is a shortcode to draw the WordPress driven RSS Widget. The Layout of RSS Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>

					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Tag Cloud Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_tag_cloud_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_tag_cloud_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_tag_cloud_widget</i> is a shortcode to draw the WordPress driven Tag Cloud Widget. The Layout of Tag Cloud Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>

					<div style="clear:both;border-top:1px solid #E5E5DB;">&nbsp;</div>
					<h2>Text Widget</h2>
					<p>Shortcode: &lt;&#63;php echo do_shortcode(&#34;[custom_page_theme_text_widget]&#34;); &#63;&gt;</p>
					<span class="left"><?php echo do_shortcode("[custom_page_theme_text_widget]"); ?></span>
					<p>
					   <i>custom_page_theme_text_widget</i> is a shortcode to draw the WordPress driven Text Widget. The Layout of Text Widget is always same that WordPress offers as default, But you can style it's Layout by your styling skills.					
					</p>


				</div>
			</div>
      </div>
    </div>
    <div id="content_footer"></div>
    <div id="footer">
      <p><a href="index.html">Home</a> | <a href="examples.html">Examples</a> | <a href="page.html">A Page</a> | <a href="another_page.html">Another Page</a> | <a href="contact.html">Contact Us</a></p>
      <p>Copyright &copy; simplestyle_banner | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">HTML5 Web Templates</a></p>
    </div>
  </div>

  <script type="text/javascript">
		var a = document.getElementById('menu').getElementsByTagName('a');
		var li = document.getElementById('menu').getElementsByTagName('li');
		li[0].classList.add('selected');
		a[0].onclick = function() {
			li[0].classList.add('selected');
			li[1].classList.remove('selected');
			li[2].classList.remove('selected');
			document.getElementsByClassName('cpt_content_title')[0].innerHTML = 'Welcome to Custom Page Theme';
			document.getElementById('tab1cnt').style.display = "block";
			document.getElementById('tab2cnt').style.display = "none";
			document.getElementById('tab3cnt').style.display = "none";
			document.getElementById('sidebar_container').style.display = "block";
		};
		a[1].onclick = function() {
			li[0].classList.remove('selected');
			li[1].classList.add('selected');
			li[2].classList.remove('selected');
			document.getElementsByClassName('cpt_content_title')[0].innerHTML = a[1].innerHTML;
			document.getElementById('tab1cnt').style.display = "none";
			document.getElementById('tab2cnt').style.display = "block";
			document.getElementById('tab3cnt').style.display = "none";
			document.getElementById('sidebar_container').style.display = "block";
		};
		a[2].onclick = function() {
			li[0].classList.remove('selected');
			li[1].classList.remove('selected');
			li[2].classList.add('selected');
			document.getElementsByClassName('cpt_content_title')[0].innerHTML = a[2].innerHTML;
			document.getElementById('tab1cnt').style.display = "none";
			document.getElementById('tab2cnt').style.display = "none";
			document.getElementById('tab3cnt').style.display = "block";
			document.getElementById('sidebar_container').style.display = "none";
		};
</script>