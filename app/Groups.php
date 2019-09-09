<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'created_by'
    ];

    /**
     * Profile relation
     */
    public function user()
    {
    	return $this->belongsTo('App\Users', 'created_by');
    }

    /**
     * User Groups relation
     */
    public function userGroups()
    {
    	return $this->belongsToMany('App\Users', 'user_groups', 'id_group', 'id_user');
    }

    /**
     * Update group
     * 
     * @var int $userId
     * @var array $data
     * 
     * @return Groups Group
     */
    public function updateGroup($groupId, $data)
    {
        $group = $this->find($groupId);
        return $group->update($data);
    }
}
