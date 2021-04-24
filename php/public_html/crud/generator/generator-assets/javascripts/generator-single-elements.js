$(document).ready(function(){
    $('input[name^=build_list]').on('ifChanged', function(e) {
        $('#list-options').slideToggle();
    });
    $('input[name^=build_vertical_list]').on('ifChanged', function(e) {
        $('#vertical-list-options').slideToggle();
    });
    $('input[name^=build_add_form]').on('ifChanged', function(e) {
        $('#add-form-options').slideToggle();
    });
    $('input[name^=build_update_form]').on('ifChanged', function(e) {
        $('#update-form-options').slideToggle();
    });
    $('input[name^=build_dependant_select]').on('ifChanged', function(e) {
        $('#dependant-select-options').slideToggle();
    });
    $('#list-options').hide();
    $('#vertical-list-options').hide();
    $('#add-form-options').hide();
    $('#update-form-options').hide();
    $('#dependant-select-options').hide();
});