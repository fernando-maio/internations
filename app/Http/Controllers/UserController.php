<?php

namespace App\Http\Controllers;

use Auth;
use App\Users;
use App\Groups;
use App\Profiles;
use Illuminate\Http\Request;
use App\Components\Validations;

class UserController extends Controller
{
    const PAGINATION = 10;
    private $users;

    /**
     * Constructor
     * 
     * @var Users $users
     */
    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    /**
     * Users list
     * 
     * @return Users $users
     */
    public function list()
    {
        $usersList = $this->users->where('id', '<>', Auth::user()->id)->where('id_profile', '<>', '1')->orderBy('id_profile')->orderBy('name');
        $users = $usersList->paginate(self::PAGINATION);
        return view('admin.users.list', array('users' => $users));
    }

    /**
     * Get create users
     * 
     * @return Response
     */
    public function getCreate()
    {
        $groups = Groups::orderBy('name')->get();
        if(Auth::user()->id_profile == 1){
            $profiles = Profiles::where('id', '<>', '1')->get();
        }else{
            $profiles = Profiles::where('id', '=', '3')->get();
        }
        return view('admin.users.create', array('profiles' => $profiles, 'groups' => $groups));
    }

    /**
     * Post create users
     *
     * @param  Request  $request
     * 
     * @return Response
     */
    public function postCreate(Request $request)
    {
        $data = $request->all();
        $validation = Validations::createUsersValidation($data);
        
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }
        
        if($this->users->createUser($data))
            return redirect()->route("users.list")->with('status', 'User created with success!');
        
        return redirect()->back()->withErrors('Error to create user. Please, try again!')->withInput();
    }

    /**
     * Get data user.
     * 
     * @param integer $hash User ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEdit($hash)
    {
        $groups = Groups::orderBy('name')->get();
        $userId = base64_decode($hash);
        $user = $this->users->findUser($userId);
        if(Auth::user()->id_profile == 1){
            $profiles = Profiles::where('id', '<>', '1')->get();
        }else{
            $profiles = Profiles::where('id', '=', '3')->get();
        }
        return view('admin.users.edit', array('user' => $user, 'profiles' => $profiles, 'groups' => $groups));
    }

    /**
     * Post update users
     *
     * @param  Request  $request
     * 
     * @return Response
     */
    public function postEdit($hash, Request $request)
    {
        $userId = base64_decode($hash);
        $data = $request->only(array('name', 'email', 'active'));
        if(Auth::user()->id == $userId && !empty($request->password)){
            $data['password'] = $request->password;
            $data['password_confirmation'] = $request->password_confirmation;
        }
        if(in_array(Auth::user()->id_profile, [1,2]) && Auth::user()->id != $userId){
            $data['id_profile'] = $request->id_profile;
            $data['blocked'] = $request->blocked;
        }
        
        $validation = Validations::updateUsersValidation($data);
        
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }

        if(!empty($request->groups)){
            $data['groups'] = $request->groups;
        }
        
        if($this->users->updateUser($userId, $data))
            return redirect()->route("users.list")->with('status', 'User updated with success!');
        
        return redirect()->back()->withErrors('Error to update user. Please, try again!')->withInput();
    }

    /**
     * Remove user.
     * 
     * @param string $hash
     *
     * @return Response
     */
    public function remove($hash)
    {
        $userId = base64_decode($hash);
        if($this->users->deleteUser($userId))
            return redirect()->route("users.list")->with('status', 'User removed with success!');
        
        return redirect()->back()->withErrors('Error to remove user. Please, try again!');
    }
}
