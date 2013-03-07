<?php
/**
 * Disable attachment page
 */
new disable_attachment_page();
 
class disable_attachment_page {
 
function __construct()
{
    add_action("template_redirect", array(&$this, "template_redirect"));
//    add_action("admin_print_styles", array(&$this, "admin_print_styles"));
}
 
/*public function admin_print_styles()
{
    echo '<style type="text/css">button.urlpost{display:none;}</style>';
}
*/
public function template_redirect()
{
    if (is_attachment() && !is_user_logged_in()) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
    }   
}
 
}