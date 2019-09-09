<?php

namespace App\Http\Controllers;

use Auth;
use App\Users;
use Illuminate\Http\Request;
use App\Components\Validations;

class PageController extends Controller
{
    /**
     * Login page
     * 
     * @return Response
     */
    public function index()
    {
        return view('admin.login');
    }

    /**
     * Post login
     * 
     * @var Request $request Login Data
     * 
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = array(
            'email' => $request->email,
            'password' => $request->password,
            'blocked' => '0'
        );

        $validate = Validations::loginValidate($credentials);
        if (!$validate->passes()) {
            return redirect()
            ->back()
            ->withErrors($validate)
            ->withInput();
        }

	    if(Auth::attempt($credentials)){
            return redirect()->route('users.list');
	    }
	    else{
	    	return redirect('/')
                ->withErrors('User not found. Check the data and try again.')
                ->withInput();
	    }
    }
}
