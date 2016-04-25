<?php
    /**
     * View helper
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    final class viewHelper {
        
        /**
         * Erzeugt Speichern Button
         * @param string $name Name des Buttons
         */
        public static function saveButton($name, $isNotUtf8 = false) {         
            self::button('submit', $name, language::returnLanguageConstant('SAVE_BTN'), 'savebtn', $isNotUtf8);
        }
        
        /**
         * Erzeugt Zuürcksetzten Button
         * @param string $name Name des Buttons
         */        
        public static function resetButton($name, $isNotUtf8 = false) {           
            self::button('reset', $name, language::returnLanguageConstant('RESET_BTN'), 'resetbtn', $isNotUtf8);            
        }        
        
        /**
         * Erzeugt Senden Button
         * @param string $name Name des Buttons
         * @param string $descr Beschreibung des Buttons
         */
        public static function submitButton($name, $descr, $class = '', $isNotUtf8 = false) {   
            if($isNotUtf8) $descr = utf8_decode($descr);
            self::button('submit', $name, $descr, 'submitbtn '.$class);
        }        
        
        /**
         * Erzeugt Button
         * @param string $type
         * @param string $name
         * @param string $descr
         * @param string $class
         */
        public static function button($type, $name, $descr, $class = '', $isNotUtf8 = false) {
            if($isNotUtf8) $descr = utf8_decode($descr);
            print "<button type=\"$type\" class=\"buttons $class\" name=\"$name\" id=\"$name\">$descr</button>";
        }
        
        /**
         * Erzeugt Select-Menü
         * @param string $name
         * @param array $options
         * @param string $selected
         * @param bool $firstEmpty
         * @param bool $firstEnabled
         */
        public static function select($name, $options, $selected = null, $firstEmpty = false, $firstEnabled = true, $isNotUtf8 = false) {
            $optionsString = '';
            
            if($firstEnabled) $optionsString = ($firstEmpty) ? '<option value=""></option>' : '<option value="">'.language::returnLanguageConstant('SELECT', null, $isNotUtf8).'</option>';            
            foreach ($options as $key => $value) {
                $optionsString .= "<option value=\"$value\"";
                if(!is_null($selected) && $value == $selected) $optionsString .= " selected=\"selected\"";
                $optionsString .= ">$key</option>";
            }
            
            $id = str_replace(array('[','(',')',']','-'), '', $name);
            
            print "<select name=\"$name\" id=\"$id\" class=\"input-select afltr-ui-select\">$optionsString</select>\n";
            
        }
        
        /**
         * Setzt bool-Wert in Text ja/nein um
         * @param bool $value
         */
        public static function boolToText($value, $isNotUtf8 = false) {
            $output = ($value == 1 || $value == true) ? '<span class="afltr-bool-to-text-icon ui-icon ui-icon-check" title="'.language::returnLanguageConstant('YES_VALUE', null, $isNotUtf8).'"></span>' : '<span class="afltr-bool-to-text-icon ui-icon ui-icon-closethick" title="'.language::returnLanguageConstant('NO_VALUE', null, $isNotUtf8).'"></span>';
            print $output;
        }
        
        /**
         * Erzeugt Ja/nein Select-Menü
         * @param string $name
         * @param array $selected
         * @return string
         */
        public static function boolSelect($name, $selected, $isNotUtf8 = false) {            
            $options = array(language::returnLanguageConstant('YES_VALUE', null, $isNotUtf8) => 1, language::returnLanguageConstant('NO_VALUE', null, $isNotUtf8) => 0);
            return self::select($name, $options, $selected, false, false);
        }        
    }
?>