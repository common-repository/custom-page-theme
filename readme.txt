=== Custom Page Theme - A Wordpress Theme Generator Plugin ===
Contributors: jeetendrabajaj
Tags: custom page theme, theme, custom page template, theme designing, design, custom page design, page theme, design theme, auto designing, automatic  
Requires at least: 4.0
Tested up to: 4.9.6
Stable tag: 4.0.8
License: GPLv2 or later


== Description ==

The Custom Page Theme Plugin is been developed for those WordPress Theme writers who have very small hands on programming. The plugin automate the whole programming stuff and helps the UI writer to more concentrate on their domain. 

Major features that Custom Page Theme include:

* Create your own WordPress Theme with no Or Least programming intervention.
* You can apply any Theme onto any section of your website no matter what Active Theme you have selected.
* The scale of your Custom page Theme may vary from applying over Single Page, Single Post or even act as a whole Active Theme itself.  
* No need to make Custom Page Template if you can make and keep a Theme and apply it to one or more pages of website in just one mouse click.
* The plugin will help you to make and keep the list of Themes as many as you want and use them any time on any section.
* The plugin makes separate theme for each template you add, it make easy removal of Themes that have no more use.
* You just have to paste small Shortcodes into your template files, the plugin itself will draw menus, page-content, comments and widgets ( like Search, Category, Meta Tags etc.) for you.


== Shortcodes ==

* Shortcode for Navigation Menu (Example: Menu Name: main menu)
  [custom_page_theme_nav menu=&#34;main menu&#34;]  OR  
  &#60;?php echo do_shortcode(&#34;[custom_page_theme_nav menu=&#92;&#34;main menu&#92;&#34;]&#34;); ?&#62; 
* Shortcode for Page content, Comment & Reply
  &#60;?php echo do_shortcode(&#34;[custom_page_theme_page_content_widget]&#34;); ?&#62;


= Disclaimer =
 
However lot of studies has been done while making this plugin. Still the plugin is in begining state, we will suggest it to first use it on some stagging installation of wordpresss. Take complete backup of your WordPress website 
before installing it on your deployed version or use it at your own risk but please do not forget to back up your files and databases before use.
If you're new to WordPress or have a very limited technical background you may consider seeking out professional help your first time using the plugin. 
For any kind of assistance from our side, you can post your suggestions on our blog section.


== Installation ==

* Upload `custom-page-theme` plugin to the `/wp-content/plugins/` folder and Activate it.
* It will add a menu 'Custom Page Theme' in admin panel in left menu. 

== YouTube Channel: CUSTOM PAGE THEME ==

 Introduction
 [youtube https://www.youtube.com/watch?v=HcnyYL7Wc_c&feature=youtu.be ]

 Installation & Making First Theme
 [youtube https://www.youtube.com/watch?v=UbZw7UfZnPI&t=144s ]
        


== Changelog ==

= 1.0.3 =
*Release Date - 02 December 2018*

* Addition of Sample Custom Page Theme, to help user make their own Themes.
* Design HTML structure of Menu Navigations and save their templates.
* Design  HTML structure of page content and save their templates. 


= 1.0.2 =
*Release Date - 06 November 2018*

* Addition of load default index.php & style.css files into add theme file.
* If user selects load default index.php or style.css, he do not need to upload both the files, insteas plugin will use both the files of it's own.
* More Readable names applied to plugin menu pages. 


= 1.0.1 =
*Release Date - 20 October 2018*

* Added a new Sub Menu 'Nav Menu Setup & Shortcodes' into 'Custom Page Theme' at the left menu of admin panel. it gives the shortcodes that if paste on templates can draw menus.
* You can also Add/Edit/Delete and Customize the HTML design of UL/LI elements the shortcode will return.



= 1.0 =
*Release Date - 29 September 2018*

* The very first release of plugin. Adds a menu 'Custom Page Theme' at the left menu of admin panel.
* It also adds a meta box 'Custom Page Theme' in Add/Edit Page page in admin panel, to select and apply themes over page.
* It also adds 2 menus 'All Custom Page Themes' & 'Add Custom Page Theme' into 'Custom Page Theme' at the left menu of admin panel.
* Both the menus manages the actions like Add/Edit/Delete & List for all the Custom Page themes.


