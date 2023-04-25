import moment from "moment";
export const dateHelper = {
    formatDate,
    calculateDays,
    calculateMonthTask
};
function formatDate(data){
    var format = data['format'] ? data['format'] : 'YYYY-MM-DD HH::mm:ss'
    return moment(data['date']).format(format);
}
function calculateDays(dateTasks){
    var today    = moment(new Date());
    dateTasks    = moment(new Date(dateTasks))
    var duration = moment.duration(dateTasks.diff(today));
    var days     = Math.round(duration.asDays());
    return days;
}
function calculateMonthTask(dateTasks){
    const date = moment().add(1, 'month'); // current date
    const firstDayOfMonth = date.startOf('month');
    const currentDateTasks = moment(new Date(dateTasks));
    const firstDayDeadline = currentDateTasks.startOf('month');
    var result = false;
    if (firstDayDeadline.unix() == firstDayOfMonth.unix()) {
        result = true;
    }
    return result
}