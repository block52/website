/*=========================================================
            word and character counter for jQuery
            Author : Gilles Migliori
            Version : 1.0
=========================================================*/

/*

$('#textareaID').wordCharCount({'maxAuthorized': 200});

résult :

<div class="counter-wrapper" id="counter-wrappertextareaID">
    <textarea id="textareaID" ...></textarea>
    <p class="compteur"><span id="word-counttextareaID">0</span> mot(s) | <span id="char-counttextareaID">0</span> Caractère(s) / settings.maxAuthorized</p>
</div>

*/

(function($)
{
    $.fn.wordCharCountTinyMce = function(textarea, options){
        var settings = $.extend({
            // defaults settings.
            wordCount: true,
            characterCount: true,
            maxAuthorized: 200,
            wordText: "word(s)",
            characterText: "character(s)",
            className: "text-primary",
            errorClassName: "text-danger"
        }, options );
        var textareaID = $(textarea, window.parent.document).attr('ID');
        var content = '<p id="p-' + textareaID + '" class="' + settings.className + '">';
        if(settings.wordCount === true) {
            content += '<span id="word-count' + textareaID + '">0</span> ' + settings.wordText;
            if(settings.characterCount === true) {
                content += ' | ';
            }
        }
        if(settings.characterCount === true) {
            content += '<span id="char-count' + textareaID + '">0</span> ' + settings.characterText;
        }
        content += ' / ' + settings.maxAuthorized;
        $('<div class="help-block text-left">').html(content).insertAfter($(textarea, window.parent.document));
        $(this).keyup(function(e) {
            var numberOfCaracters = $(this).text().length;
            var numberOfWords = jQuery.trim($(this).text()).split(' ').length;
            if($(this).text() === '') {
                numberOfWords = 0;
            }
            if($('#word-count' + textareaID, window.parent.document)[0]) {
                $('#word-count' + textareaID, window.parent.document).text(numberOfWords);
            }
            if($('#char-count' + textareaID, window.parent.document)[0]) {
                $('#char-count' + textareaID, window.parent.document).text(numberOfCaracters);
            }
            if(settings.characterCount === false) {
                if (numberOfWords > settings.maxAuthorized) {
                    $('#p-' + textareaID, window.parent.document).addClass(settings.errorClassName);
                } else if($('#p-' + textareaID, window.parent.document).hasClass(settings.errorClassName)) {
                    $('#p-' + textareaID, window.parent.document).removeClass(settings.errorClassName);
                }
            } else {
                if (numberOfCaracters > settings.maxAuthorized) {
                    $('#p-' + textareaID, window.parent.document).addClass(settings.errorClassName);
                } else if($('#p-' + textareaID, window.parent.document).hasClass(settings.errorClassName)) {
                    $('#p-' + textareaID, window.parent.document).removeClass(settings.errorClassName);
                }
            }
        });
        $(this).trigger('keyup');
    };
})(jQuery);