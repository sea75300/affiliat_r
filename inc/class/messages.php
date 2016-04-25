<?php
    /**
     * Message class
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    final class messages {
        
        private static $messages = array();
        
        private static $isNotUtf8 = false;
        
        private static $disableFadeOut = false;

        /**
         * Schreibt $logLine in Error-Log
         * @param string $logLine
         */
        public static function logError($logLine) {
            $errorLog = base_config::$logfiles['errors'];
            $LogLine = json_encode(array('time' => time(),'text' => print_r($logLine, true)));
            file_put_contents($errorLog, $LogLine.PHP_EOL, FILE_APPEND);
        }

        /**
         * Schreibt $logLine in System-Log
         * @param string $logLine
         */        
        public static function logSystem($logLine) {
            $errorLog = base_config::$logfiles['system'];
            $LogLine = json_encode(array('time' => time(),'text' => print_r($logLine, true)));
            file_put_contents($errorLog, $LogLine.PHP_EOL, FILE_APPEND);
        }        
        
        /**
         * Registriert Meldung zur Ausgabe unter Header
         * @param string $message
         */
        public static function registerNotice($message, $disableFadeOut = false) {            
            self::$messages['notices'][] = $message;
            self::$disableFadeOut = (!self::$disableFadeOut) ? $disableFadeOut : true;
        }
        
        /**
         * Registriert Meldung zur Ausgabe unter Header
         * @param string $message
         */
        public static function registerError($message, $disableFadeOut = false) {            
            self::$messages['errors'][] = $message;            
            self::$disableFadeOut = (!self::$disableFadeOut) ? $disableFadeOut : true;
        }   
        
        /**
         * Registriert Meldung zur Ausgabe unter Header
         * @param string $message
         */        
        public static function registerMessage($message, $disableFadeOut = false) {            
            self::$messages['msg'][] = $message;
            self::$disableFadeOut = (!self::$disableFadeOut) ? $disableFadeOut : true;
        }        

        
        /**
         * zeigt alle registrierten Meldungen an
         */        
        public static function showMessages() {
            
            if(count(self::$messages) == 0) return;
                
            $disableFadeOutClass = self::$disableFadeOut ? '-diabled' : '';
            
            print "<div class=\"afltr-messagebox fadeout$disableFadeOutClass\">";

            foreach (self::$messages as $type => $messages) {
                switch ($type) {
                    case 'msg' :
                        array_walk($messages, 'self::showNotices');
                    break;
                    case 'errors' :
                        array_walk($messages, 'self::showError');
                    break;
                    default:
                        array_walk($messages, 'self::showNeutral');
                    break;
                }
            }
            
            print "</div>";
        }
        
        /**
         * Zeigt wichtige Nachrichten an
         * @param string $message
         */
        private static function showNotices($message) {
            if(self::$isNotUtf8) $message = utf8_decode ($message);
            print "<div class=\"afltr-msg-notice ui-state-highlight ui-corner-all\"><p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span> $message</p></div>";
        }
        
        /**
         * Zeigt Fehler-Nachrichten an
         * @param string $message
         */        
        private static function showError($message) {
            if(self::$isNotUtf8) $message = utf8_decode ($message);
            print "<div class=\"afltr-msg-error ui-state-error ui-corner-all\"><p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .3em;\"></span> $message</p></div>";
        }
        
        /**
         * Zeigt neutrale Nachrichten an
         * @param string $message
         */        
        private static function showNeutral($message) {
            if(self::$isNotUtf8) $message = utf8_decode ($message);
            print "<div class=\"afltr-msg-neutral ui-state-highlight ui-corner-all\"><p><span class=\"ui-icon ui-icon-lightbulb\" style=\"float: left; margin-right: .3em;\"></span> $message</p></div>";
        }                
        
        /**
         * Versendet E-Mail über php-Funktion mail()
         * @param array $mailData Array mit Daten der Email
         * Struktur:
         *      'mailTo'       => Empfänger (optional)
         *      'mailFrom'     => Ansender (optional)
         *      'mailSubject'  => Betreff
         *      'mailText'     => Text der E-Mail
         */
        public static function sendEMail($mailData) {            
            if(!isset($mailData["mailFrom"])) { $mailData["mailFrom"] = "affiliatr@".$_SERVER["HTTP_HOST"]; }           
            if(!isset($mailData["mailTo"]))  {
                self::registerError(language::returnLanguageConstant('MSG_EMAIL_NO_TO'));
            }
           
            $mret = mail($mailData["mailTo"],
                 $mailData["mailSubject"],
                 $mailData["mailText"],
                 "From: ".$mailData["mailFrom"]
            ); 
            
            if($mret) {
                self::logSystem("An e-mail was send to ".$mailData["mailTo"]." width subject ".$mailData["mailSubject"]);
                return true;
            }
            
            self::logSystem("The e-Mail to ".$mailData["mailTo"]." width subject ".$mailData["mailSubject"]." cannot be send.");
            return false;            
        }        
    }
?>