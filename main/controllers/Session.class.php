<?php

/*
 * Copyright 2015 Vin Wong @ vinexs.com
 *
 * All rights reserved.
 */

class Session extends MainApp
{

    /** Valid $token and retrieve user data. */
    function recover_session_by_token($token)
    {
        $this->load_plugin('Mcrypt');
        $mcrypt = new Mcrypt($this->manifest['session_encrypt']);
        $data = explode('.', $mcrypt->decrypt(base64_decode($token)));
        if (!isset($data[2])) {
            return false;
        }
        $user_id = $data[1];
        $create_at = $data[2];
        return $this->retrieve_user_data($user_id);
    }

    /** Load member model and return user data by $user_id */
    function retrieve_user_data($user_id)
    {
        /* TODO example
            $this->load_model('Session_model', 'session');
            if( ( $userdata = $this->session->get_user_by_id( $user_id ) ) == false )
            {
                return false;
            }
            return $userdata;
        */
    }

    /** Process user submited variable and query user_id from database. */
    function handler_process_login()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $session_only = $this->post('keep_login', 'boolean', false);
        if (empty($username) or empty($password)) {
            return $this->show_json(false, 'invalid_param');
        }
        if (!function_exists('mcrypt_encrypt') or !isset($this->manifest['session_encrypt'])) {
            return $this->show_json(false, 'server_not_supported');
        }
        /* TODO example
            $this->load_model('Session_model', 'session');
            if( ($user_id = $this->session->verify_user( $username, $password ) ) == false )
            {
                return $this->show_json( false, 'user_not_found' );
            }
            if( ( $user_data = $this->retrieve_user_data( $user_id ) ) == false )
            {
                return $this->show_json( false, 'user_profile_invalid' );
            }
        */
        $this->create_session_recover_cookie($user_id, $session_only);
        return $this->show_json(true, 'login_success');
    }

    /** Set a cookie which contain encrypted user id. */
    function create_session_recover_cookie($user_id, $session_only = true)
    {
        $this->load_plugin('Mcrypt');
        $mcrypt = new Mcrypt($this->manifest['session_encrypt']);
        $code = base64_encode($mcrypt->encrypt(rand(100, 999) . '.' . $user_id . '.' . date('Y-m-d H:i:s')));
        setcookie($this->manifest['session_token'], $code, ($session_only ? 0 : time() + 315360000), '/', $_SERVER['SERVER_NAME'], false);
    }

    /** Process change user password */
    function handler_process_change_password()
    {
        $old_password = $this->post('old_password');
        $new_password = $this->post('new_password');
        if (empty($old_password) or empty($new_password)) {
            return $this->show_json(false, 'invalid_param');
        }
        /* TODO example
            $this->load_model('Session_model', 'session');
            $status = $this->session->change_user_password( $user_id, $old_password, $new_password );
        */
        if (!$status) {
            return $this->show_json(false, 'change_fail');
        }
        return $this->show_json(true, 'change_success');
    }

    /** Remove cookie to process logout. */
    function handler_process_logout()
    {
        $this->remove_session_recover_cookie();
        return $this->show_json(true, 'logout_success');
    }

    /** Remove the cookie which contain encrypted user id for logout. */
    function remove_session_recover_cookie()
    {
        setcookie($this->manifest['session_token'], '', time() - 315360000, '/', $_SERVER['SERVER_NAME'], false);
    }

}