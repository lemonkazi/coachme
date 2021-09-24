<?php

    return [
        'image' => [
            'required' => 'File is required',
            'image' => 'File is is not a valid image',
            'mimes' => 'Invalid image format',
            'max' => 'Image size must be less thant 20MB',
        ],
        'unauthorized_to_create_service_admin' => 'Unauthorized to create or update service admin',
        'unauthorized_to_create_service_and_building_admin' => 'Unauthorized to create or update service and building admin',
        'unauthorized_to_other_building_admin' => 'Unauthorized to create or update other building admin',
        'unauthorized_to_other_rink_admin' => 'Unauthorized to create or update other building shop admin',
        'unauthorized_to_other_building_rink_admin' => 'Unauthorized to create or update other shop admin',
        'success_message' => 'Request successful',
        'error_message' => 'Request failed',
        'users' => [
            'deleted_successfully' => 'User deleted successfully',
            'could_not_be_deleted' => 'User could not be deleted',
        ],
        'registration' => [
            'success_message' => 'Registration successful',
            'error_message' => 'Registration failed',
        ],
        'building_id' => [
            'required' => 'Please select a building name',
            'numeric' => 'Building value should be numeric',
            'invalid' => 'Building is not valid',
        ],
        'company_id' => [
            'required' => 'Please select a company name',
            'numeric' => 'Company value should be numeric',
            'invalid' => 'Company is not valid',
            'building_mismatch' => 'Company is not associated with selected building',
        ],
        'shop_id' => [
            'required' => 'Please select a shop name',
            'numeric' => 'Shop value should be numeric',
            'invalid' => 'Shop is not valid',
            'building_mismatch' => 'Shop is not associated with selected building',
        ],
        'rink_id' => [
            'required' => 'Please select a rink name',
            'numeric' => 'Rink value should be numeric',
            'invalid' => 'Rink is not valid',
        ],
        'name' => [
            'required' => 'Please enter a username',
            'max' => 'Name must be less than 255 characters',
        ],
        'email' => [
            'required' => 'Please enter your e-mail address',
            'string' => 'E-mail address must be text',
            'email' => 'E-mail address must be valid',
            'max' => 'E-mail address must be less than 255 characters',
            'already_registered' => 'E-mail address already registered',
        ],
        'password' => [
            'required' => 'Please enter a password',
            'min' => 'Password must be minimum 8 characters',
            'confirmed' => 'Password and confirm password must be same',
        ],
        'image' => [
            'url' => 'Image must be a valid url'
        ],
        'gender' => [
            'required' => 'Please select a gender',
            'string' => 'Gender value must be text',
            'in' => 'Gender value can be MALE or FEMALE or OTHER only',
        ],
        'birthday' => [
            'required' => 'Please enter your date of birth',
            'date_format' => 'Birthday must be in yyyy/mm/dd format',
        ],
        'department' => [
            'required' => 'Please enter a department name',
            'string' => 'Department must be text',
        ],
        'authority' => [
            'required' => 'Authority is required',
            'in' => 'Authority must be one of SERVICE_ADMIN, BUILDING_ADMIN, SHOP_ADMIN, WORKER',
        ],
        'point' => [
            'required' => 'Please enter points',
            'deleted_successfully' => 'Point deleted successfully',
            'could_not_be_deleted' => 'Point could not be deleted',
        ],
        'password' => [
            'required' => 'password required',
            'min' => 'Minimum 8 degit required',
            'confirmed' => 'check confirmed',
            'same' => 'same',
            'current'=>'current pass'
        ],
        'current_password' => [
            'required' => 'current password required',
            'min' => 'minumum 8 required',
            'confirmed' => 'confirmed',
            'current'=>'current password wrong'
        ],
        'new_password' => [
            'required' => 'required',
            'min' => 'min 8 required',
            'confirmed' => 'confirmed not match',
            'current'=>'check current',
            'same' =>'new password not matched with confirmed password'
        ],
    ];
