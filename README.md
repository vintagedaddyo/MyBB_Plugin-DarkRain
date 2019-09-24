# MyBB_Plugin-DarkRain


DarkRain

Adds beautiful dark rain to your board.

Author: Vintagedaddyo

This Plugin is perfect for dark rainy days. It adds dark rain to your board with the option to turn the dark rain on or off via the user cp

To install, just copy the files from the ZIP-archive into the right directory of your server and activate the Plugin in the admin control panel.

Compatibility
MyBB 1.8: Yes

Because this plugin places a dark canvas in the background it modifies the background properties of body #logo and #content...., it also overrides font color for those as well as for .navigation .active and .navigation…,

body and #content are marked as !important for override but I left #logo without !important so that if you are using the color_whatever.css in say the default theme you can go into say for example color_black.css and find #logo and mark as !important to override

ie:

Change:

#logo {
    background: #202020 url(images/colors/black_header.png) top left repeat-x;
    border-bottom: 1px solid #000;
}


To:

#logo {
    background: #202020 url(images/colors/black_header.png) top left repeat-x !important;
    border-bottom: 1px solid #000;
}
