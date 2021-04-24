/*==============================================
            colorColumns (auth:migli)
==============================================*/

/*

Add background-color to table columns

Argumentss:
    Array : columns indexes
    Color

Usage :
    $('#table').colorColumns([2, 4], '#F4F0E3');
*/

(function($)
{
    $.fn.colorColumns=function(columnsNumbersArray, color){
        var rows = this.children('tbody').children('tr');
        rows.each(function(trCount){
            $(this).children('td').each(function(tdCount) {
                if($.inArray(tdCount + 1, columnsNumbersArray) > -1) {
                    $(this).css('background-color', color);
                }
            });
        });
        return this;
    };
})(jQuery);
