<?php

    class nnorg_afltr_common {

        public static function install() {
            if(!is_writable(__DIR__)) {
                self::show_message(__('Unable to save configuration changes. The plugin folder is not writable.', 'nnorg-wp-affiliatr'));
            } else {
                file_put_contents(NNORG_AFLTR_SETTINGS_CFG, '/affiliat_r/');
            }
        }

        public static function uninstall() {
            if(is_writable(__DIR__)) { @unlink(NNORG_AFLTR_SETTINGS_CFG); }
        }

        public static function register_menu() {
            add_options_page(
                    'Affiliat*r Integration',
                    'Affiliat*r Integration',
                    'manage_options', 'nnorg-wp-affiliatr.php', array(__CLASS__, 'acp_page'));
        }

        public static function acp_page() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_style("jquery-ui-css", "//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");              

            $saved = true;
            
            if(!is_writable(__DIR__)) {
                self::show_message(__('Unable to save configuration changes. The plugin folder is not writable.', 'nnorg-wp-affiliatr'));
            }
            
            if (isset($_POST['Update'])) {
                $nnorg_afltr_path = esc_html(trim($_POST['nnorg_afltr_path']));

                if (file_exists(get_home_path() . $nnorg_afltr_path)) {
                    file_put_contents(NNORG_AFLTR_SETTINGS_CFG, $nnorg_afltr_path);
                } else {
                    self::show_message(__('The new path has not been found and was not saved!', 'nnorg-wp-affiliatr'), true);
                    $saved = false;
                }
            }

            if (file_exists(NNORG_AFLTR_SETTINGS_CFG)) {
                $nnorg_afltr_path = file_get_contents(NNORG_AFLTR_SETTINGS_CFG);
            }

            if($saved) {
                if (file_exists(get_home_path() . $nnorg_afltr_path) && file_exists(get_home_path() . $nnorg_afltr_path . '/inc/config/config.php')) {
                    self::show_message(__('Path has been found!', 'nnorg-wp-affiliatr'));
                } else {
                    self::show_message(__('The given path was not found!', 'nnorg-wp-affiliatr'), true);
                }                
            }           
            
            include 'nnorg-wp-affiliatr-view.php';
        }
        
        public static function page($config) {            
            if(!isset($config['action'])) { return '<p>No action param found!</p>'; }
            
            $base_path = dirname(dirname(dirname(__DIR__)));
            if(strpos($base_path, 'wordpress') !== false) $base_path = dirname($base_path);
            
            $nnorg_afltr_path = $base_path.'/'.file_get_contents(NNORG_AFLTR_SETTINGS_CFG);

            include_once $nnorg_afltr_path.'/inc/common.php';
            include_once $nnorg_afltr_path.'/inc/controllers.php';                    

            $isUtf8 = (isset($config['isnotutf8'])) ? (int) $config['isnotutf8'] : false;
            
            if($config['action'] == 'showAffiliates') {                            
                $CtrlConfig['acceptedOnly'] = (isset($config['acceptedonly'])) ? (int) $config['acceptedonly'] : true;
                $CtrlConfig['textOnly']     = (isset($config['textonly'])) ? (int) $config['textonly'] : 0;
                $CtrlConfig['openBlank']    = (isset($config['openblank'])) ? (int) $config['openblank'] : false;
                $CtrlConfig['view']         = (isset($config['view']) && !empty($config['view'])) ? $config['view'] : null;
                $CtrlConfig['isNotUtf8']    = $isUtf8;                      
                
                $controller = new \pub\affiliate_list(
                    $config['category'],
                    $CtrlConfig['view'],
                    $CtrlConfig['acceptedOnly'],
                    $CtrlConfig['textOnly'],
                    $CtrlConfig['openBlank'],
                    $CtrlConfig['isNotUtf8']
                );
                $controller->setReturnRender(true);
            }   

            if($config['action'] == 'showApplyForm') {                        
                $controller = new \pub\apply($isUtf8);
                $controller->setReturnRender(true);
            }   

            if($config['action'] == 'showBannerList') {
                $maxSize = array();
                $maxSize['width'] = (isset($config['maxWidth']) ? $config['maxWidth'] :  array());
                $maxSize['height'] = (isset($config['maxHeight']) ? $config['maxHeight'] :  array());
                
                $controller = new \pub\linkbanner($isUtf8, $maxSize);
                $controller->setReturnRender(true);
            }

            return $controller->process();
        }

        public static function show_message($message, $errormsg = false) {
            if(empty($message)) return;
            
            if ($errormsg) {
                print '<div id="message" class="error">';
            } else {
                print '<div id="message" class="updated fade">';
            }
            print '<p><strong>' . $message . '</strong></p></div>';
        }
        
        private static function parse_config_string_values ($value) {            
            if($value == 'true') { return true; }            
            if($value == 'false') { return false; }   
            if(is_numeric($value)) { return (int) $value; }
            return $value;            
        }
        
        public static function dump($config) {
            print "<pre>";
            var_dump($config);
            print "</pre>";             
        }

    }
