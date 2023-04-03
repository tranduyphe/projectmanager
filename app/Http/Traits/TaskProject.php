<?php
namespace App\Http\Traits;
use App\Models\User;
use App\Models\Label;

trait TaskProject {

    /**
     * show list member in task
     * @param string $data list user id in task 
     */
    public function listMembers($data) 
    {
        $members = [];
        $lists = explode(",", $data);
        foreach ($lists as $k => $id) {
            $members[$id] = User::find($id);
        }
        return $members;
    }

    /**
     * show list labels in task
     * @param string $data list label id in task 
     */
    public function listLabels($data) 
    {
        $labels = [];
        $lists = explode(",", $data);
        foreach ($lists as $k => $id) {
            $labels[$id] = Label::find($id);
        }
        return $labels;
    }
}