Custom Starkers Wordpress Template
==================================

This is a compilation of techniques we commonly use when developing Wordpress sites. While the bare-bones Starkers theme is a great boilerplate, we noticed that we would remove a good bulk of the comments and a fair amount of functionality (extra layouts, css files, and logic). We've also adjusted it to our conventions (css, functions, etc) and added reusable code snippets. 

Custom Fields
-------------
Inside the lib directory is a file called custom fields, which contains code adapted from this [blog post](http://sltaylor.co.uk/blog/control-your-own-wordpress-custom-fields/). It is intended to be a lightweight solution for adding custom fields to different post types (e.g. pages, posts, and custom post types). If a custom field is defined for particular post type, when you visit the edit page, you'll see a field designed specifically for it (e.g. text, textarea, checkbox). This can make it easier for non-technical users to make updates; in contrast to the default custom fields GUI in which you have to use a generic key/value system.

*Without Custom Fields (Wordpress default)*

![Image of Custom Fields Disabled](http://img.skitch.com/20110315-8wk31p49pdjsf6whm6f2tm51np.png)

*With Custom Fields enabled*

![Image of Custom Fields Enabled](http://img.skitch.com/20110315-c5nn7jg98h5jwm667kjux5xmex.png)



Changes to Starkers
-------------------
* Removed a large number of comments for readability.
* Removed archive layouts for tags and categories, this will have them default to archives.php which handles the proper heading.
* Removed twentyten\_filter\_wp\_title() from functions.php, since it conflict with the _All in one SEO Pack_ plugin.
* Removed screenshot.png and other starkers images.
* Removed the following infrequently used templates: attachment.php, author.php, loop-attachment.php, loop-page.php, loop-single.php, onecolumn-page.php, and sidebar-footer.php.
* Simplified the functionality in loop.php and header.php.
* Removed html5 elements from header.php.
* Added skeleton structure for a custom post type and taxonomy in functions.php. This is to get started quickly without referring to documentation.
* Added lib directory with custom\_fields.php, a pseudo-plugin for creating fields for post types with a specific GUI. There is an example of how to use it in functions.php.
* Added searchform.php which overrides the Wordpress default search form.