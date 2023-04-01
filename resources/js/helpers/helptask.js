import { store } from '../store/store';
export const taskHelper = {
    isEmptyObject,
    convertToObject,
    updateDataTask,
};

function isEmptyObject(obj) {
    return Object.keys(obj).length === 0;
}

function convertToObject(obj) {
    if (typeof obj != 'undefined' && obj.length > 0) {
        var object = obj.reduce(
        (obj, item) => Object.assign(obj, { [item.id]: item.id }), {});
        return object;
    }else{
        return {};
    }
}
 /**
 * add and remove use,label in current task
 * @param {*} obj in obj key: action, id, data, key, field, task_id
 * @param {*} action active or deactive
 * @param {*} id user id, label id
 * @param {*} data data of user or label
 * @param {*} key key get data of current task use key
 * @param {*} field field data task by field
 */
async function updateDataTask( obj ) {
    // action, id_data, data, key, field, task_id
    var dataUpdated = store.getters.currentTask[obj['key']];
    var task_id = store.getters.currentTask.id;

    if (!dataUpdated) {
        dataUpdated = {};
    }

    if ( obj['action'] == 'deactive' ) {
        delete dataUpdated[obj['id']];
    }else{
        dataUpdated[obj['id']] = obj['data'];
    } 

    var listArray = Object.keys(dataUpdated); // convert data Obj to array by key dataupdated
    var fields = {};
        fields[obj['field']] = listArray ? listArray.join(",") : "";
    var data = {};
    data["task_id"] = task_id;
    data["info_task"] = fields;
    console.log(store.getters.listTasks[task_id])  
    // update task
    await store.dispatch( 'updateTask', data ); // callback function

    // update data in task
    if (store.getters.currentTask[obj['field']]) {
        store.getters.listTasks[task_id][obj['key']] = store.getters.currentTask[obj['key']];
    } else {
        store.getters.listTasks[task_id][obj['key']] = false;
    }  
    console.log('after', store.getters.listTasks[task_id]) 
}