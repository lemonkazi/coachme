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
    'email_send' => 1,

    'period'=> array(
        'winter'=> 'December to february',
        'Spring'=> 'march to may',
        'Summer'=> 'June to august',
        'Fall'=> 'september to  november'
    ),

    'seasons'    => array(
        'spring'    => array('March 1'     , 'May 31'),
        'summer'    => array('June 1'      , 'August 31'),
        'fall'      => array('September 1' , 'November 30'),
        'winter'    => array('December 1'  , 'February 28')
    ),

    // get the season dates
    'spring' => new DateTime('March 1'),
    'summer' => new DateTime('June 1'),
    'fall' => new DateTime('September 1'),
    'winter' => new DateTime('December 1')

    
  ];