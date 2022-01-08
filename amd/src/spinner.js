define([], function() {
    return {
        init: function() {
            var iframeElem = document.getElementById('block_onlineexam_contentframe');
            var contentElem = document.getElementById('block_onlineexam_exams_content');

            iframeElem.addEventListener('load', function() {
                contentElem.className = contentElem.className.replace(/block_onlineexam_is-loading/, '');
            }, true);
        }
    };
});
