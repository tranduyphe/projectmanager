import { forEach } from 'lodash';
import { store } from '../store/store';
export const taskHelper = {
    isEmptyObject,
    convertToObject,
    updateDataTask,
    addWorkTodo,
    addcheckLists,
    calculateListWorkTodo
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
    // update task
    await store.dispatch( 'updateTask', data ); // callback function

    // update data in task
    if (store.getters.currentTask[obj['field']]) {
        store.getters.listTasks[task_id][obj['key']] = store.getters.currentTask[obj['key']];
    } else {
        store.getters.listTasks[task_id][obj['key']] = false;
    }  
}

 /**
 * add work todo
 * @param {*} data
 */
async function addWorkTodo( data ) {
    
    // create
    if (store.getters.currentTask.works.length == 0) {
        store.getters.currentTask.works = {}
    }
    var results = await store.dispatch( 'createWorkTodo', data ); // callback function 
    if (typeof store.getters.currentTask.works[results.id] == 'undefined') {
        store.getters.currentTask.works[results.id] = {}
    }
    store.getters.currentTask.works[results.id] = results;
}

 /**
 * add check list todo
 * @param {*} data key=> id of work todo
 * 
 */
async function addcheckLists( data ) {
    var task_id = store.getters.currentTask.id;
    if (store.getters.currentTask.works.length == 0) {
        store.getters.currentTask.works = {} // add works todo in currents
    }

    if (store.getters.listTasks[task_id].works.length == 0) {
        store.getters.listTasks[task_id].works = {} // add works todo in list task
    }
    var result = await store.dispatch( 'addCheckList', data );
    if (typeof result != 'undefined') {
        if (store.getters.currentTask.works[data.id]['check_list'].length == 0) {
            store.getters.currentTask.works[data.id]['check_list'] = {};
            store.getters.listTasks[task_id].works[data.id]['check_list'] = {};
        }
        if (typeof store.getters.currentTask.works[data.id]['check_list'][result.id] == 'undefined') {
            store.getters.currentTask.works[data.id]['check_list'][result.id] = {};
            store.getters.listTasks[task_id].works[data.id]['check_list'][result.id] = {};
        }
        store.getters.currentTask.works[data.id]['check_list'][result.id] = result;
        store.getters.listTasks[task_id].works[data.id]['check_list'][result.id] = result;
    }
}

 /**
 * add check list todo
 * @param {*} data key=> id of work todo
 * 
 */
function calculateListWorkTodo(data) {
    // console.log(data);
    var total = 0;
    var done  = 0;
    for (const key in data) {
        var listCheck = data[key];
        total = total + Object.keys(listCheck['check_list']).length;
    }
    var results = {
        'total': total,
        'done': done
    };
    return results;
}