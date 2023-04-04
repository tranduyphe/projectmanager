<?php
namespace App\Http\Traits;
use App\Models\User;
use App\Models\Label;
use App\Models\Tasks;
use App\Models\WorkToDo;

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

    /**
     * show list work to do in task
     * @param number id of task 
     */
    public function listWorks($id) 
    {
        $listWorks = [];
        $work = Tasks::with('worktodo')->find($id);
        if (!empty($work->worktodo)) {
            foreach ($work->worktodo as $key => $v) {
                $listWorks[$v->id] = $v;
                $listWorks[$v->id]['check_list'] = self::checkLists($v->id);
            }
        }
        return $listWorks;
    }

    /**
     * show check list in work todo
     * @param number id of work todo
     */
    public function checkLists($id) 
    {
        $checkLists = [];
        $works = WorkToDo::with('checklist')->find($id);
        if (!empty($works->checklist)) {
            foreach ($works->checklist as $key => $v) {
                $checkLists[$v->id] = $v;
                $checkLists[$v->id]['status'] = $v->status ? true : false;
            }
        }
        return $checkLists;
    }
}