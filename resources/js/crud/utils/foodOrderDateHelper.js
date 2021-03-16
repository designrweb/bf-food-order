import moment from 'moment';

export const isPermitToCancelItem = function (date) {
    //can be cancelled until 9 am of the same day
    let currentDate    = new Date(moment(new Date()).format('YYYY-MM-DD'));
    let checkingDate   = new Date(date);
    let weekDifference = moment(checkingDate).isoWeek() - moment(currentDate).isoWeek();
    let currentYear = parseInt(moment(new Date()).format('YYYY'));
    let checkingDateYear = parseInt(moment(checkingDate).format('YYYY'))

    if (checkingDate.getTime() == currentDate.getTime() && weekDifference == 0) {
        let currentHour = parseInt(moment(new Date()).format('HH'));
        return currentHour < 9;
    } else if (checkingDate > currentDate || (weekDifference > 0 && checkingDateYear >= currentYear)) {
        return true;
    }

    return false;
};

export const isPermitToAddItem = function (date) {
    //allow to add for tomorrow until 1pm of today
    let currentDate    = new Date(moment(new Date()).format('YYYY-MM-DD'));
    let checkingDate   = new Date(date);
    let todayIndex     = parseInt(moment(currentDate).format('e'));
    let dayDifference  = parseInt(moment(checkingDate).format('e')) - parseInt(moment(currentDate).format('e'));
    let weekDifference = moment(checkingDate).isoWeek() - moment(currentDate).isoWeek();
    let currentHour    = parseInt(moment(new Date()).format('HH'));
    let currentYear = parseInt(moment(new Date()).format('YYYY'));
    let checkingDateYear = parseInt(moment(checkingDate).format('YYYY'))
    let result         = false;
    if (weekDifference == 0) {
        result = true;
        // for current week
        if (dayDifference == 1) {
            // for tomorrow
            result = currentHour < 13;
        } else if (dayDifference <= 1) {
            // for previous days of current week
            result = false;
        }
    } else if (weekDifference == 1) {
        // for next week
        result = true;

        if (
            (dayDifference == -4 && todayIndex == 4) ||
            (dayDifference == -5 && todayIndex == 5) ||
            (dayDifference == -6 && todayIndex == 6)
        ) {
            // for Friday, Saturday and Sunday
            result = currentHour < 13;
        }
    } else if (weekDifference > 1 && currentYear <= checkingDateYear) {
        // for 2+ weeks
        result = true;
    }

    return result;
};
