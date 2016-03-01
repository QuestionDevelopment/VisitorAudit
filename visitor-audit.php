<?php
/**
 * Plugin Name: Visitor Audit
 * Plugin URI: http://VisitorAudit.com
 * Description: Allows you to easily view your current visitors, analyze their behaviour, deduce their experience and identify malicious behavior
 * Version: 1.0.0
 * Author: Justin Campo
 * Author URI: http://campo.cc
 * License: GPL2
 */

 
if(!class_exists('\Visitor_Audit\Visitor_Audit_Config')) {
    require_once(dirname(__FILE__) . '/visitor-audit.config.php');
}
if(!class_exists('\Visitor_Audit\Visitor_Audit_Setup')) {
    require_once(dirname(__FILE__) . '/visitor-audit.setup.php');
}
if(!class_exists('\Visitor_Audit\Visitor_Audit')) {
    require_once(dirname(__FILE__) . '/visitor-audit.class.php');
}
if(class_exists('\Visitor_Audit\Visitor_Audit')) {
    $wp_visitor_audit = new \Visitor_Audit\Visitor_Audit();
    register_activation_hook(__FILE__, array(&$wp_visitor_audit, 'activate'));
    register_deactivation_hook(__FILE__, array(&$wp_visitor_audit, 'deactivate'));
    add_action('plugins_loaded', array(&$wp_visitor_audit, 'init'));
    add_action('shutdown', array(&$wp_visitor_audit, 'history'));
}


if (is_admin()) {
    if(!class_exists('\Visitor_Audit\Visitor_Audit_Admin')) {
        require_once(dirname(__FILE__) . '/visitor-audit.admin.php');
    }
    if(class_exists('\Visitor_Audit\Visitor_Audit')) {
        $wp_visitor_audit_admin = new Visitor_Audit\Vistor_Audit_Admin($wp_visitor_audit);
        add_action('admin_init', array(&$wp_visitor_audit_admin, 'visitor_audit_settings'));
        add_action('admin_menu', array(&$wp_visitor_audit_admin, 'add_menu'));
        add_action('admin_enqueue_scripts', array(&$wp_visitor_audit_admin, 'javascript'));
        add_action('wp_ajax_visitor_audit_details', array(&$wp_visitor_audit_admin, 'ajax_details'));
        add_action('wp_ajax_visitor_audit_history', array(&$wp_visitor_audit_admin, 'ajax_history'));
        add_action('wp_ajax_visitor_audit_ban_temp', array(&$wp_visitor_audit_admin, 'ajax_ban_temp'));
        add_action('wp_ajax_visitor_audit_ban_perm', array(&$wp_visitor_audit_admin, 'ajax_ban_perm'));
        add_action('wp_ajax_visitor_audit_ban_remove', array(&$wp_visitor_audit_admin, 'ajax_ban_remove'));
    }
}