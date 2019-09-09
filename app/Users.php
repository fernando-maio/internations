<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'id_profile',
        'active',
        'blocked',
    ];

    /**
     * Profile relation
     */
    public function profile()
    {
    	return $this->belongsTo('App\Profiles', 'id_profile');
    }

    /**
     * User relation
     */
    public function createdBy()
    {
    	return $this->hasMany('App\Groups', 'created_by');
    }

    /**
     * User Groups relation
     */
    public function userGroups()
    {
    	return $this->belongsToMany('App\Groups', 'user_groups', 'id_user', 'id_group');
    }

    /**
     * Find user
     * 
     * @var int $userId
     * 
     * @return Users User
     */
    public function findUser($userId)
    {
        $user = $this->find($userId);
        $groups = array();
        foreach($user->userGroups as $group){
            $groups[] = $group->id;
        }
        $user['groups'] = $groups;
        
        return $user;
    }

    /**
     * Create users
     * 
     * @var array $data
     * 
     * @return Users New User
     */
    public function createUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        if(isset($data['groups']))
            return $this->create($data)->userGroups()->sync($data['groups']);
        else
            return $this->create($data);
    }

    /**
     * Update users
     * 
     * @var int $userId
     * @var array $data
     * 
     * @return Users User
     */
    public function updateUser($userId, $data)
    {
        $user = $this->find($userId);
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        if(isset($data['groups'])){
            $user->userGroups()->sync($data['groups']);
        } else{
            $user->userGroups()->detach();
        }
        
        return $user->update($data);
    }

    /**
     * Delete user
     * 
     * @var integer $id
     * 
     * @return bool|null
     */
    public function deleteUser($userId)
    {
        $user = $this->find($userId);
        $user->userGroups()->detach();
        return $user->delete();
    }
}
