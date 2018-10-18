jQuery(document).ready(function() {
    jQuery('.page-content').addClass('toggled');

    jQuery('.sidebar-dropdown > a').click(function() {
        jQuery('.sidebar-submenu').slideUp(200);

        if (jQuery(this).parent().hasClass('active')) {
            jQuery('.sidebar-dropdown').removeClass('active');
            jQuery(this).parent().removeClass('active');
        } else {
            jQuery('.sidebar-dropdown').removeClass('active');
            jQuery(this).next('.sidebar-submenu').slideDown(200);
            jQuery(this).parent().addClass('active');
        }
    });

    jQuery('#close-sidebar').click(function() {
        jQuery('.page-wrapper').removeClass('toggled');
    });

    jQuery('#show-sidebar').click(function() {
        jQuery('.page-wrapper').addClass('toggled');
    });
});