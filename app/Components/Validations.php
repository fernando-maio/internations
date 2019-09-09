<?php

namespace App\Components;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Validations
{
    /**
     * Validate login
     * 
     * @var array $data
     * 
     * @return Validator
     */
    public static function loginValidate($data)
    {
        $rules = array(
            'email' => 'required|email|max:255',
            'password' => 'required'
        );

        $messages = array(
	    	'email.required' => 'Insert email',
	    	'email.email' => 'Invalid email format',
	    	'email.max' => 'Max 255 characters',
	    	'password.required' => 'Insert a password'
        );
        
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Validation users register
     * 
     * @param array $data Request values
     * 
     * @return Validator
     */
    public static function createUsersValidation($data)
    {
        $rules = array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'id_profile' => 'required',
            'password' => 'required|min:6|confirmed'
        );

        $messages = array(
	    	'name.required' => 'Insert name',
	    	'name.max' => 'Name must contains up to 255 characters',
	    	'email.required' => 'Insert email',
	    	'email.email' => 'Invalid email format',
	    	'email.max' => 'Max 255 characters',
	    	'email.unique' => 'Email already exists',
	    	'id_profile.required' => 'Select profile',
	    	'password.required' => 'Insert a password',
	    	'password.min' => 'The password must contain at least 6 characters',
	    	'password.confirmed' => 'Password and Confirm password values are different'
    	);

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Validation users register
     * 
     * @param array $data Request values
     * 
     * @return Validator
     */
    public static function updateUsersValidation($data)
    {
        $rules = array(
            'name' => 'required|max:255'
        );

        $messages = array(
	    	'name.required' => 'Insert name',
	    	'name.max' => 'Name must contains up to 255 characters'
        );
        
        if(isset($data['password'])){
            $rules['password'] = 'required|min:6|confirmed';
            $messages['password.required'] = 'Insert a password';
            $messages['password.min'] = 'The password must contain at least 6 characters';
            $messages['password.confirmed'] = 'Password and Confirm password values are different';
        }

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Validate new group
     * 
     * @var array $data
     * 
     * @return Validator
     */
    public static function groupValidate($data)
    {
        $rules = array(
            'name' => 'required|min:2|max:255|unique:groups'
        );

        $messages = array(
	    	'name.required' => 'Insert email',
	    	'name.min' => 'The name must contain at least 2 characters',
            'name.max' => 'Max 255 characters',
            'name.unique' => 'Group already exists'
        );
        
        return Validator::make($data, $rules, $messages);
    }
}