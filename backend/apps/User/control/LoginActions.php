<?php

namespace apps\User\control;

use \lib\register\Vars;
use \lib\url\Redirect;
use \lib\session\WordpressSession;

/**
 * Description of LoginActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 20, 2016
 */
class LoginActions extends \lib\control\ControllerAdmin {

    /**
     *
     */
    public function loginAction()
    {
        global $wpdb;
        //$result = $wpdb->get_row( "SELECT * FROM $wpdb->users" );
        //var_dump($result);
    }

    /**
     *
     */
    public function validateLoginAction(){
        $user = Vars::getPosts('u');
        $pass = Vars::getPosts('p');
        
        add_filter( 'authenticate', [$this, 'allowProgrammaticLogin'], 10, 3 );

        $result = wp_authenticate($user, $pass);
        if ($result->errors) {
            $this->setErrors($result->errors);
            $this->setView('login');
            $this->loginAction();
            return;
        }

        $user = wp_signon(['user_login' => $user, 'user_password' => $pass], true);
        remove_filter( 'authenticate', 'allow_programmatic_login', 10, 3 );
        if (is_a($user, 'WP_User')) {
            wp_set_current_user($user->ID, $user->user_login);

            if (is_user_logged_in()) {
                WordpressSession::setUserLogged($user);
                Redirect::redirectToUrl('/backend/home');
                return true;
            }
        }
        return;
    }
    
    public function allowProgrammaticLogin($user, $username, $password)
    {
        return get_user_by('login', $username);
    }

    private function setErrors($errors){
        $this->set('logmessage', 1);
        if($errors['incorrect_password']){
            $this->set('error-message', $errors['incorrect_password'][0]);
        }
    }

}
