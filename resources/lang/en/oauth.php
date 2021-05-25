<?php 
    return [
        'logout_success' => 'You have successfully logged out',
        'refresh_token' => [
            'required' => 'refresh_token is required',
        ],
        'grant_type' => [
            'required' => 'grant_type is required',
            'in' => 'grant_type must be any of password and refresh_token',
        ],
        'grant_type_otp' => [
            'in' => 'grant_type must be otp',
        ],
        'client_id' => [
            'required' => 'client_id is required',
            'numeric' => 'client_id must be numeric',
            'max' => 'client_id is too large',
        ],
        'client_secret' => [
            'required' => 'client_secret is required',
        ],
        'client_type' => [
            'required' => 'client_type is required',
            'in' => 'client_type must be any of ios, android, and web',
        ],
        'push_token' => [
            'required' => 'push_token is required',
        ],
        'invalid_request' => 'The refresh token is invalid',
        'invalid_credentials' => 'Email or password is not correct',
        'invalid_grant' => 'Email or password is not correct',
        'invalid_client' => 'client_id or client_secret is incorrect',
        'unauthenticated' => 'The user is not authenticated',
        'not_found' => 'Not found',
        'email_send_reset_password' => 'Reset password email send successfully',
        'please_complete_signup' => 'Sign up has not been completed. Please use your phone number to verify your identity',
        'update_password_successfully' => 'update password successfully done',
    ];