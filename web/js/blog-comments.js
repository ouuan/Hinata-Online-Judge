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

function qqStickers() {
	$('.comtbox1').each(function() {
		var text = $(this)[0].innerHTML;
		text = text.replace(/\/kel/g, '<img src="/images/qq/kelian.gif" class="qq-stickers" alt="[可怜]">');
		text = text.replace(/\/kk/g, '<img src="/images/qq/kuaikule.gif" class="qq-stickers" alt="[快哭了]">');
		text = text.replace(/\/dk/g, '<img src="/images/qq/daku.gif" class="qq-stickers" alt="[大哭]">');
		text = text.replace(/\/jk/g, '<img src="/images/qq/jingkong.gif" class="qq-stickers" alt="[惊恐]">');
		text = text.replace(/\/xyx/g, '<img src="/images/qq/xieyanxiao.gif" class="qq-stickers" alt="[斜眼笑]">');
		text = text.replace(/\/cy/g, '<img src="/images/qq/ciya.gif" class="qq-stickers" alt="[呲牙]">');
		text = text.replace(/\/px/g, '<img src="/images/qq/penxue.gif" class="qq-stickers" alt="[喷血]">');
		text = text.replace(/\/xk/g, '<img src="/images/qq/xiaoku.gif" class="qq-stickers" alt="[笑哭]">');
		text = text.replace(/\/se/g, '<img src="/images/qq/se.gif" class="qq-stickers" alt="[色]">');
		$(this)[0].innerHTML = text;
	});
}

$(function() {
	qqStickers();
	markComments();
	addPaginationListeners();
	addEmojioneArea();
	addCopyButtons();
	highlightAllCodes();
});
