<?php

namespace App\Http\Controllers;

use Auth;
use App\Groups;
use Illuminate\Http\Request;
use App\Components\Validations;

class GroupController extends Controller
{
    const PAGINATION = 10;
    private $groups;

    /**
     * Constructor
     * 
     * @var Groups $groups
     */
    public function __construct(Groups $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Groups list
     * 
     * @return Groups $groups
     */
    public function list()
    {
        $groupsList = $this->groups->orderBy('name');
        $groups = $groupsList->paginate(self::PAGINATION);
        return view('admin.groups.list', array('groups' => $groups));
    }

    /**
     * Get create groups
     * 
     * @return Response
     */
    public function getCreate()
    {
        return view('admin.groups.create');
    }

    /**
     * Post create groups
     *
     * @param  Request  $request
     * 
     * @return Response
     */
    public function postCreate(Request $request)
    {
        $data = $request->only(['name']);
        $validation = Validations::groupValidate($data);
        
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }
        
        $data['created_by'] = Auth::user()->id;
        
        if($this->groups->create($data))
            return redirect()->route("groups.list")->with('status', 'Group created with success!');
        
        return redirect()->back()->withErrors('Error to create group. Please, try again!')->withInput();
    }

    /**
     * Get data group.
     * 
     * @param integer $hash Group ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEdit($hash)
    {
        $groupId = base64_decode($hash);
        $group = $this->groups->find($groupId);
        return view('admin.groups.edit', array('group' => $group));
    }

    /**
     * Post update group
     *
     * @param  Request  $request
     * 
     * @return Response
     */
    public function postEdit($hash, Request $request)
    {
        $groupId = base64_decode($hash);
        $data = $request->only(['name']);
        $validation = Validations::groupValidate($data);
        
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }
        
        $data['created_by'] = Auth::user()->id;
        
        if($this->groups->updateGroup($groupId, $data))
            return redirect()->route("groups.list")->with('status', 'Group updated with success!');
        
        return redirect()->back()->withErrors('Error to update group. Please, try again!')->withInput();
    }

    /**
     * Remove group.
     * 
     * @param string $hash
     *
     * @return Response
     */
    public function remove($hash)
    {
        $groupId = base64_decode($hash);
        $group = $this->groups->find($groupId);
        
        if(count($group->userGroups) > 0){
            return redirect()->back()->withErrors('You have users associate with this group. Remove this association before.');
        }

        if($group->delete())
            return redirect()->route("groups.list")->with('status', 'Group removed with success!');
        
        return redirect()->back()->withErrors('Error to remove group. Please, try again!');
    }
}
