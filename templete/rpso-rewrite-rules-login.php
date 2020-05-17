<?php 
defined( 'ABSPATH' ) or die(); 
# Protect from alien invasion

# OTP page rewrite rule

namespace Realpro\Rewrite\Rules;

class RPSO_Rewrite_Rules_Login
{

    protected static $instance = NULL;

    public function __construct()
    {    
    }

    
    public static function get_instance()
    {
        NULL === self::$instance and self::$instance = new self;
        return self::$instance;
    }

    public function setup()
    {
        add_action('init', array($this, 'rpso_login_rewrite_rules'));
        add_filter('query_vars', array($this, 'query_vars'), 10, 1);
        add_action('parse_request', array($this, 'parse_request'), 10, 1);

        register_activation_hook(__FILE__, array($this, 'flush_rules'));
    }

    public static function rpso_login_rewrite_rules()
    {
        add_rewrite_tag('%rpso_auth%', '([^&]+)');
        add_rewrite_rule( '^verify-login/([^/]*)/?', 'index.php?rp_api=1&rpso_auth=$matches[1]', 'top' );
    }

    public function flush_rules()
    {
        $this->rpso_login_rewrite_rules();
        flush_rewrite_rules();
    }

    public function query_vars($vars)
    {
        $vars[] = 'rpso_api';
        $vars[] = 'rpso_error';
        return $vars;
    }

    public function parse_request(&$wp)
    {
        if (array_key_exists('rpso_api', $wp->query_vars)) {
            include  __DIR__  . '/verify-login.php';
            exit();
        }
    }
}

?>