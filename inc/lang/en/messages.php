<?php
    /**
     * Messages language file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array(
        'WRONG_PASSWORD'  => 'The entered password was wrong! Please try again.',
        'NO_LOGIN'        => 'You must log in to open this page!',
        'VIEW_NOT_FOUND'  => 'The view {{viewname}} was not found!',
        
        'SAVE_SUCCESS_ADDAFFILIATE'     => 'The affiliate has been saved!',
        'SAVE_SUCCESS_ADDCATEGORY'      => 'The category has been saved!',
        'SAVE_SUCCESS_EDITAFFILIATE'    => 'Changes to the affiliate were saved!',
        'SAVE_SUCCESS_EDITCATEGORY'     => 'Changes to the category were saved!',
        'SAVE_SUCCESS_OPTIONS'          => 'Changes to the system configuration were saved!',
        
        'SAVE_FAILED_AFFILIATE'         => 'The affiliate could <b>not</b> be saved!',  
        'SAVE_FAILED_CATEGORY'          => 'The category could <b>not</b> be saved!',                
        'SAVE_FAILED_PASSWORD'          => 'The ACP password must include Uppercase and lowercase letters, numbers and at least six digits.', 
        
        'DELETE_SUCCESS_AFFILIATES'     => 'The selected affiliates have been deleted!',
        'DELETE_SUCCESS_CATEGORIES'     => 'The selected categories have been deleted!',
        'DELETE_SUCCESS_FILES'          => 'The selected files have been deleted!',
                
        'MSG_EMAIL_NO_TO'               => 'You have to enter an email address to submit your application.',
        
        'APPLY_OK'                      => 'Your application has been sent.',
        'APPLY_FAILED'                  => 'Your application could not be sent!',
        'APPLY_FAILED_SPAM'             => 'The answer to the security question was incorrect!',
        'APPLY_MAIL_SUBJECT'            => 'Apply as {{affiliateKategory}}',
        'APPLY_MAIL_TEXT'               => '{{name}} has sent an application with {{page}} in category {{affiliateKategory}}. {{acpLink}}',
        
        'INSTALL_SUCCESS'               => '"You got it, Jim!" Affiliat*r was installed successfully.',
        'INSTALL_DELETE_FOLDER'         => 'In case it still exists, please delete the /install/ folder in Affiliat*r root folder before you try to login.',
        
        'UPDATE_NEWVERSION'             => 'A new version is out there! <b><a class="buttons afltr-update-btn" href="{{versionlink}}">Start Update</a></b>',
        'UPDATE_NOTAUTOCHECK'           => 'Could not create a connection to the update server!',
        'UPDATE_ADDITIONAL_STEPS'       => 'Running additional steps!',
        'UPDATE_SUCCESS'                => 'The update was completed successfully!',
        'UPDATE_FAILED'                 => 'The update <b>failed</b>!!',
        
        'DOWNLOAD_PCK_SUCCESS'          => 'Downloading update package was successful.',
        'DOWNLOAD_PCK_FAILED'           => 'An error occurred while downloading update package! (see system log)',
        
        'UNPACK_PCK_SUCCESS'            => 'Unpacking update package was successful.',
        'UNPACK_PCK_FAILED'             => 'An error occurred while unpacking update package! (see system log)',
        
        'DASH_CONTAINER_INSTANCE'       => '<b>{{dashcontainer}}</b> must be an instance of <b>\interfaces\dashcontainer</b>.',
        
        'LOGIN_PASSWORD_RESET'          => 'A new acp password has been requested!',
        'LOGIN_PASSWORD_RESET_FAILED'   => 'the acp password cout not be reseted!',
        
        'CACHE_CLEARED_OK'              => 'The cache has been cleaned up!',
        'CACHE_CLEARED_FAILED'          => 'An error occurred while clearing the cache!'
    );

?>