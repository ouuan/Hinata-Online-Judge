function addEmojioneArea() {
	$(".form-control").each(function() {
		$(this).emojioneArea();
	});
}

function markComments() {
	$('.comtbox1').each(function() {
		var text = $(this)[0].innerHTML;
		text = text.replace(/&gt;/g, '>').replace(/&lt;/g, '<').replace(/&amp;/g, '&');
		$(this)[0].innerHTML = marked(text);
	});
}

function addPaginationListeners() {
	MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
	$('ul.pagination li a').on('click', function(e) {
		// looks funny but it works
		addPaginationListeners();
	});
}

$(function() {
	addEmojioneArea();
	markComments();
	addPaginationListeners();
	addCopyButtons();
	highlightAllCodes();
});
