<?php
/*
 * MyBB: DarkRain
 *
 * File: darkrain.php
 * 
 * Author: Vintagedaddyo
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.0
 * 
 *
 */

// Disallow direct access to this file for security reasons

if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook("usercp_options_end", "darkrain_usercp");
$plugins->add_hook("usercp_do_options_end", "darkrain_usercp");
$plugins->add_hook('pre_output_page','darkrain');

function darkrain_info()
{
   global $lang;

    $lang->load("darkrain");
    
    $lang->darkrain_Desc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' . 
        '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' .
        '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->darkrain_Desc;

    return Array(
        'name' => $lang->darkrain_Name,
        'description' => $lang->darkrain_Desc,
        'website' => $lang->darkrain_Web,
        'author' => $lang->darkrain_Auth,
        'authorsite' => $lang->darkrain_AuthSite,
        'version' => $lang->darkrain_Ver,
        'compatibility' => $lang->darkrain_Compat
    );
}

function darkrain_install() {
    global $db;
    
    // Add field for user option
    
    $db->query("ALTER TABLE ".TABLE_PREFIX."users ADD showDarkRain int NOT NULL default '1'");
}

function darkrain_is_installed()
{
    global $db;
    
    if($db->field_exists("showDarkRain", "users"))
    {
        return true;
    }
    else 
    {
        return false;
    }
}

function darkrain_uninstall()
{
    global $db;
    
    if($db->field_exists("showDarkRain", "users"))
        $db->query("ALTER TABLE ".TABLE_PREFIX."users DROP COLUMN showDarkRain");
}

function darkrain_usercp() {
    global $db, $mybb, $templates, $user, $lang;
    $lang->load('darkrain');
    
    if($mybb->request_method == "post")
    {
        $update_array = array(
            "showDarkRain" => intval($mybb->input['showDarkRain'])
        );      
        $db->update_query("users", $update_array, "uid = '".$user['uid']."'");
    }
    
    $add_option = '</tr><tr>
<td valign="top" width="1"><input type="checkbox" class="checkbox" name="showDarkRain" id="showDarkRain" value="1" {$GLOBALS[\'$showDarkRainChecked\']} /></td>
<td><span class="smalltext"><label for="showDarkRain">{$lang->darkrain_show_question}</label></span></td>';

    $find = '{$lang->show_codebuttons}</label></span></td>';
    $templates->cache['usercp_options'] = str_replace($find, $find.$add_option, $templates->cache['usercp_options']);
    
    $GLOBALS['$showDarkRainChecked'] = '';
    if($user['showDarkRain'])
        $GLOBALS['$showDarkRainChecked'] = "checked=\"checked\"";
}

function darkrain($page)
{
    global $mybb;
    
    if($mybb->user['showDarkRain']) {
        $page=str_replace('</head>','<style>body{ background: transparent !important; color: #FFF !important;} #logo{ background: transparent;} #content{ background: transparent !important; color: #FFF !important;} .navigation .active { color: #FFF !important;} .navigation { color: #FFF !important;}</style><canvas id="canvas" style="position : fixed; top : 0px; left : 0px; width:100vw; height:100vh; z-index:-9999; display: block;"></canvas><script type="text/javascript" src="'.$mybb->settings['bburl'].'/inc/plugins/darkrain/dat.gui.min.js"></script><script type="text/javascript" src="'.$mybb->settings['bburl'].'/inc/plugins/darkrain/darkrain.gui.js"></script></head>',$page);
    }
    
    return $page;
}

?>