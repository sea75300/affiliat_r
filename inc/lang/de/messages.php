<?php
    /**
     * Messages language file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array(
        'WRONG_PASSWORD'  => 'Das eingegebene Passwort ist falsch! Bitte versuche es erneut.',
        'NO_LOGIN'        => 'Um diese Seite aufzurufen musst du dich einloggen!',
        'VIEW_NOT_FOUND'  => 'Die View {{viewname}} wurde nicht gefunden!',
        
        'SAVE_SUCCESS_ADDAFFILIATE'     => 'Der Affiliate wurde gespeichert!',
        'SAVE_SUCCESS_ADDCATEGORY'      => 'Die Kategorie wurde gespeichert!',
        'SAVE_SUCCESS_EDITAFFILIATE'    => 'Die Änderungen am Affiliate wurden gespeichert!',
        'SAVE_SUCCESS_EDITCATEGORY'     => 'Die Änderungen an der Kategorie wurden gespeichert!',
        'SAVE_SUCCESS_OPTIONS'          => 'Die Änderungen an der Konfiguration wurde gespeichert!',
        
        'SAVE_FAILED_AFFILIATE'         => 'Der Affiliate konnte <b>nicht</b> gespeichert werden!',  
        'SAVE_FAILED_CATEGORY'          => 'Die Kategorie konnte <b>nicht</b> gespeichert werden!',                
        'SAVE_FAILED_PASSWORD'          => 'Das ACP-Password muss Groß- und Kleinbuchstaben sowie Zahlen enthalten und min. 6 Zeichen lang sein.', 
        
        'DELETE_SUCCESS_AFFILIATES'     => 'Die Affiliates wurden gelöscht!',
        'DELETE_SUCCESS_CATEGORIES'     => 'Die Kategorien wurden gelöscht!',
        'DELETE_SUCCESS_FILES'          => 'Die Dateien wurden gelöscht!',
                
        'MSG_EMAIL_NO_TO'               => 'Um deine Bewerbung abzuschicken, musst du deine E-Mail-Adresse eingeben',
        
        'APPLY_OK'                      => 'Deine Bewerbung wurde versendet.',
        'APPLY_FAILED'                  => 'Deine Bewerbung konnte nicht versendet werden!',
        'APPLY_FAILED_SPAM'             => 'Die Sicherheitsfrage wurde nicht richtig beantwortet!',
        'APPLY_MAIL_SUBJECT'            => 'Bewerbung als {{affiliateKategory}}',
        'APPLY_MAIL_TEXT'               => '{{name}} hat sich mit {{page}} als {{affiliateKategory}} beworben. {{acpLink}}',
        
        'INSTALL_SUCCESS'               => 'Herzlichen Glückwunsch. Affiliat*r wurde erfolgreich installiert.',
        'INSTALL_DELETE_FOLDER'         => 'Lösche (falls noch vorhanden) vor dem Login bitte unbedingt den Ordner /install/ im Affiliat*r-Verzeichnis.',
        
        'UPDATE_NEWVERSION'             => 'Eine neue Version ist verfügbar! <b><a class="buttons afltr-update-btn" href="{{versionlink}}">Starte Update</a></b>',
        'UPDATE_NOTAUTOCHECK'           => 'Es konnte keine automatische Verbindung zum Update-Server hergestellt werden!',
        'UPDATE_ADDITIONAL_STEPS'       => 'Zusätzliche Schritte werden ausgeführt!',
        'UPDATE_SUCCESS'                => 'Das Update wurde erfolgreich durchgeführt!',
        'UPDATE_FAILED'                 => 'Das Update konnte <b>nicht</b> erfolgreich durchgeführt werden!',
        
        'DOWNLOAD_PCK_SUCCESS'          => 'Das Herunterladen der Paket-Datei war erfolgreich.',
        'DOWNLOAD_PCK_FAILED'           => 'Beim Herunterladen der Paket-Datei ist ein Fehler aufgetreten! (siehe Systemlogs)',
        
        'UNPACK_PCK_SUCCESS'            => 'Das Entpacken der Paket-Datei war erfolgreich.',
        'UNPACK_PCK_FAILED'             => 'Beim Entpacken der Paket-Datei ist ein Fehler aufgetreten! (siehe Systemlogs)',
        
        'DASH_CONTAINER_INSTANCE'       => '<b>{{dashcontainer}}</b> muss das Interface <b>\interfaces\dashcontainer</b> implementieren.',
        
        'LOGIN_PASSWORD_RESET'          => 'Ein neues ACP-Passwort wurde angefordert!',
        'LOGIN_PASSWORD_RESET_FAILED'   => 'Das ACP-Passwort konnte nicht zurückgesetzt werden!',
        
        'CACHE_CLEARED_OK'              => 'Der Cache wurde geleert!',
        'CACHE_CLEARED_FAILED'          => 'Beim Leeren des Caches ist ein Fehler aufgetreten!'
    );

?>