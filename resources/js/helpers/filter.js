import { dateHelper } from "@/js/helpers/datehelper";
export const filterDataProject = {
    filterTaskProject
}
/**
 * filter user
 * data[date] => checck dealine date of task => 
 * value[no]: not deadline in task
 * value[out_date]: expiration date in task
 * value[week_date]: task deadline in next week
 * value[month_date]: task deadline in next month
 * @param {*} data 
 * @returns 
 */
function filterTaskProject(data){
    var dataTask = data['dataTask'];
    var users = data['users'] ? data['users'] : false;
    // user[no] => show all task not user
    // user[list_user] => show user by user in task
    let results;

    switch (data['checkDate']) {        
        case 'no':
            // filter task using user in task and not date deadline in task
            if (users) {
                if (typeof users['no'] == 'undefined' && typeof users['list_user'] != 'undefined') {
                    if (!dataTask.deadline && typeof dataTask.members != 'undefined') {
                        results = dataInUser(users['list_user'], dataTask);
                    }
                    return results;
                }else if(typeof users['no'] != 'undefined' && typeof users['list_user'] == 'undefined'){
                    if (!dataTask.deadline) {
                        results = !dataTask.members                    
                    }
                    return results;
                }else {
                    if (!dataTask.deadline) {
                        if (typeof dataTask.members != 'undefined') {
                            for (const key in data['users']['list_user']) {
                                const idUser = data['users']['list_user'][key];
                                if (dataTask.members[idUser]) {
                                    results = dataTask
                                }
                            }
                        }else{
                            results = dataTask
                        }                        
                    }
                    return results;
                } 
            } else {
                return !dataTask.deadline;
            }
        case 'out_date':
            // filter task using user in task and expiration date in task
            if (users) {
                if (typeof users['no'] == 'undefined' && typeof users['list_user'] != 'undefined') {
                    if ( dataTask.deadline && typeof dataTask.members != 'undefined' && dateHelper.calculateDays(dataTask.deadline) < 0 ) {
                        results = dataInUser(users['list_user'], dataTask);
                    }
                    return results;
                }else if(typeof users['no'] != 'undefined' && typeof users['list_user'] == 'undefined'){
                    if (dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) < 0) {
                        results = !dataTask.members                    
                    }
                    return results;
                }else {
                    if (dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) < 0) {
                        if (typeof dataTask.members != 'undefined') {
                            results = dataInUser(users['list_user'], dataTask);
                        }else{
                            results = dataTask
                        }                        
                    }
                    return results;
                } 
            } else {
                return dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) < 0;
            }
        case 'day_date':
            // filter task using user in task and date deadline in tomorrow            
            if (users) {
                if (typeof users['no'] == 'undefined' && typeof users['list_user'] != 'undefined') {
                    if ( dataTask.deadline && typeof dataTask.members != 'undefined' && dateHelper.calculateDays(dataTask.deadline) > 0 && dateHelper.calculateDays(dataTask.deadline) <= 1) {
                        results = dataInUser(users['list_user'], dataTask);
                    }
                    return results;
                }else if(typeof users['no'] != 'undefined' && typeof users['list_user'] == 'undefined' ){
                    if (dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) > 0 && dateHelper.calculateDays(dataTask.deadline) <= 1) {
                        results = !dataTask.members                    
                    }
                    return results;
                }else {
                    if (dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) > 0 && dateHelper.calculateDays(dataTask.deadline) <= 1) {
                        if (typeof dataTask.members != 'undefined') {
                            results = dataInUser(users['list_user'], dataTask);
                        }else{
                            results = dataTask
                        }                        
                    }
                    return results;
                } 
            } else {
                return dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) > 0 && dateHelper.calculateDays(dataTask.deadline) <= 1;
            }
        case 'week_date':
            // filter task expiration date in next week
            if (users) {
                if (typeof users['no'] == 'undefined' && typeof users['list_user'] != 'undefined') {
                    if ( dataTask.deadline && typeof dataTask.members != 'undefined' && dateHelper.calculateDays(dataTask.deadline) > 6 && dateHelper.calculateDays(dataTask.deadline) <= 14) {
                        results = dataInUser(users['list_user'], dataTask);
                    }
                    return results;
                }else if(typeof users['no'] != 'undefined' && typeof users['list_user'] == 'undefined' ){
                    if (dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) > 6 && dateHelper.calculateDays(dataTask.deadline) <= 14) {
                        results = !dataTask.members                    
                    }
                    return results;
                }else {
                    if (dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) > 6 && dateHelper.calculateDays(dataTask.deadline) <= 14) {
                        if (typeof dataTask.members != 'undefined') {
                            results = dataInUser(users['list_user'], dataTask);
                        }else{
                            results = dataTask
                        }                        
                    }
                    return results;
                } 
            } else {
                return dataTask.deadline && dateHelper.calculateDays(dataTask.deadline) > 6 && dateHelper.calculateDays(dataTask.deadline) <= 14;
            }            
        case 'month_date':
            // filter task expiration date in next month
            if (users) {
                if (typeof users['no'] == 'undefined' && typeof users['list_user'] != 'undefined') {
                    if ( dataTask.deadline && typeof dataTask.members != 'undefined' && dateHelper.calculateMonthTask(dataTask.deadline)) {
                        results = dataInUser(users['list_user'], dataTask);
                    }
                    return results;
                }else if(typeof users['no'] != 'undefined' && typeof users['list_user'] == 'undefined' ){
                    if (dataTask.deadline && dateHelper.calculateMonthTask(dataTask.deadline)) {
                        results = !dataTask.members                    
                    }
                    return results;
                }else {
                    if (dataTask.deadline && dateHelper.calculateMonthTask(dataTask.deadline)) {
                        if (typeof dataTask.members != 'undefined') {
                            results = dataInUser(users['list_user'], dataTask);
                        }else{
                            results = dataTask
                        }                        
                    }
                    return results;
                } 
            } else {
                return dataTask.deadline && dateHelper.calculateMonthTask(dataTask.deadline);
            }           
        default:
            return dataTask;
    } 
}

// function return data by member;
const dataInUser = (dataUser, dataTask) => {
    var results
    for (const key in dataUser) {
        const idUser = dataUser[key];
        if (dataTask.members[idUser]) {
            results = dataTask
        }
    }
    return results;
}