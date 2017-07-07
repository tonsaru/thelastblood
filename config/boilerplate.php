<?php

return [

    'sign_up' => [
        'release_token' => env('SIGN_UP_RELEASE_TOKEN'),
        'validation_rules' => [
          'name' => 'required|string|max:191|Alpha|unique:users',
          'blood' => 'required|string|max:2',
          'email' => 'required|string|email|max:191|unique:users',
          'password' => 'required|string|min:6|confirmed',
          'blood' => 'required|string|max:2',
          'blood_type' => 'required|string|max:8',
          'birthyear' => 'required|integer|max:3000',
          'phone' => 'required|string|max:10|unique:users',
          'province' => 'required|string|max:255',
          'password_confirmation' => 'required|string|min:6',
          'firstname' => 'required|string|Alpha',
          'lastname' => 'required|string|Alpha',
        ],
        'message' => [
            'name.required' => 'A name is required',
            'email.required'  => 'A email is required',
            'name.unique' => 'name unique',
            'email.unique' => 'email unique'
        ]
    ],

    'login' => [
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

    'forgot_password' => [
        'validation_rules' => [
            'email' => 'required|email'
        ]
    ],

    'reset_password' => [
        'release_token' => env('PASSWORD_RESET_RELEASE_TOKEN', false),
        'validation_rules' => [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]
    ],

    'roomreq_create' => [
        'validation_rules' => [
            'patient_id' => 'required',
            'patient_name' => 'required',
            'patient_blood' => 'required',
            'patient_blood_type' => 'required',
            'patient_detail' => 'required',
            'patient_province' => 'required',
            'patient_hos' => 'required',
            'countblood' => 'required',
        ],
        'message' => [
            'patient_id.required' => 'patient_id required',
            'patient_name.required' => 'patient_name required',
            'patient_blood.required' => 'patient_blood required',
            'patient_blood_type.required' => 'patient_blood_type required',
            'patient_detail.required' => 'patient_detail required',
            'patient_province.required' => 'patient_province required',
            'countblood.required' => 'countblood required',
            'patient_hos.required' => 'patient_hos required',
        ]
    ],

    'friend_create' => [
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

];
