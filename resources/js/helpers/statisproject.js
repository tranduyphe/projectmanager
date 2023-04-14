export const staticProject = {
    statisticalTasks
};
/**
 *  function add or remove user in project
 *  @param {*} data key action: active or deactive, user_id, project id
 */
function statisticalTasks(data){
    var totalTask     = 0;
    var totalTaskDone = 0;
    var percent       = 0;
    if (data.length > 0) {
        totalTask = data.length;        
        var taskDone = data.filter((item)=>{
            return item.card_id === 4
        });
        totalTaskDone = taskDone.length;
        percent = Math.round(100/totalTask * totalTaskDone);
    }
    return percent+"%";
}