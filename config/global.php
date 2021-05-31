<?php 
  return [
    'app_debug' => env('APP_DEBUG', false),
    'mail_from_address' => env('MAIL_FROM_ADDRESS'),
    'mail_from_name' => env('MAIL_FROM_NAME'),
    'android_reset_pass_url' => env('ANDROID_RESET_PASSWORD_URL'),
    'ios_reset_pass_url' => env('IOS_RESET_PASSWORD_URL'),
    'mail_reset_pass_url' => env('MAIL_RESET_PASSWORD_URL'),
    'mail_reset_pass_title' => env('MAIL_RESET_PASSWORD_TITLE'),
    'mail_reset_pass_sub' => env('MAIL_RESET_PASSWORD_SUBJECT'),   
    'support_page_url' => env('SUPPORT_PAGE_URL'),
    'password_reset_token_validity' => env('PASSWORD_RESET_TOKEN_VALIDITY'),
    'email_send' => 1
  ];