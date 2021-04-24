// English

jQuery.extend(jQuery.fn.pickadate.defaults, {
    monthsFull: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    weekdaysFull: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    today: 'Today',
    clear: 'Clear',
    close: 'Close',
    firstDay: 1,
    format: 'd mmmm, yyyy',
    formatSubmit: undefined,
    labelMonthNext: 'Next month',
    labelMonthPrev: 'Previous month',
    labelMonthSelect: 'Select a month',
    labelYearSelect: 'Select a year'
});
if (typeof jQuery.fn.pickatime != 'undefined') {
    jQuery.extend(jQuery.fn.pickatime.defaults, {
        clear: 'Clear'
    });
}
