// mark comments

function markComments() {
        marked.setOptions({
                highlight: function (code) {
                        return hljs.highlightAuto(code).value;
                }
        });
        $('.comtbox1').each(function() {
                var text = $(this)[0].innerHTML;
                text = text.replace(/&gt;/g, '>').replace(/&lt;/g, '<').replace(/&amp;/g, '&');
                $(this)[0].innerHTML = marked(text);
        });
}

function addMathJaxListeners() {
	MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        $('ul.pagination li a').on('click', function(e) {
                // seems funny but it works
                addMathJaxListeners();
        });
}

$(function() {
        markComments();
        addMathJaxListeners();
});
