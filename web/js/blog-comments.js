function emojiComments() {
	$('.comtbox1').each(function() {
		var text = $(this)[0].innerHTML;
		text = text.replace(/&gt;/g, '>').replace(/&lt;/g, '<').replace(/&amp;/g, '&');
		emojione.imagePathPNG = '/images/emoji/';
		$(this)[0].innerHTML = emojione.toImage(text);
	});
}

function addEmojioneArea() {
	$(".form-control").each(function() {
		$(this).emojioneArea();
		emojione.imagePathPNG = '/images/emoji/';
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
	emojiComments();
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