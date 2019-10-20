function addEmojioneArea() {
	$(".form-control").each(function() {
		$(this).emojioneArea();
	});
}

function markComments(id) {
	$(id ? id + '.comtbox5' : '.comtbox1,.comtbox5').each(function() {
		var text = $(this)[0].innerHTML;
		text = text.replace(/&gt;/g, '>').replace(/&lt;/g, '<').replace(/&amp;/g, '&');
		text = text.replace(/<script/g, '&lt;script').replace(/<\/script>/g, '&lt;/script&gt;');
		text = text.replace(/<frame/g, '&lt;frame').replace(/<\/frame>/g, '&lt;/frame&gt;');
		text = text.replace(/<iframe/g,'&lt;iframe').replace(/<\/iframe>/g, '&lt;/iframe&gt;');
		$(this)[0].innerHTML = marked(text);
	});
}

function qqStickers(pa) {
	$(id ? id + '.comtbox5' : '.comtbox1,.comtbox5').each(function() {
		var text = $(this)[0].innerHTML;
		text = text.replace(/\/kel/g, '<img src="/images/qq/kelian.gif" alt="[可怜]">');
		text = text.replace(/\/kk/g, '<img src="/images/qq/kuaikule.gif" alt="[快哭了]">');
		text = text.replace(/\/dk/g, '<img src="/images/qq/daku.gif" alt="[大哭]">');
		text = text.replace(/\/jk/g, '<img src="/images/qq/jingkong.gif" alt="[惊恐]">');
		text = text.replace(/\/xyx/g, '<img src="/images/qq/xieyanxiao.gif" alt="[斜眼笑]">');
		text = text.replace(/\/cy/g, '<img src="/images/qq/ciya.gif" alt="[呲牙]">');
		text = text.replace(/\/px/g, '<img src="/images/qq/penxue.gif" alt="[喷血]">');
		text = text.replace(/\/xk/g, '<img src="/images/qq/xiaoku.gif" alt="[笑哭]">');
		text = text.replace(/\/se/g, '<img src="/images/qq/se.gif" alt="[色]">');
		text = text.replace(/\/youl/g, '<img src="/images/qq/youling.gif" alt="[幽灵]">');
		text = text.replace(/\/fad/g, '<img src="/images/qq/fadou.gif" alt="[发抖]">');
		text = text.replace(/\/tsh/g, '<img src="/images/qq/tiaosheng.gif" alt="[跳绳]">');
		$(this)[0].innerHTML = text;
	});
}

function addPaginationListeners(id) {
	qqStickers(id);
	markComments(id);
	MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
	$(id + ' ul.pagination li a').on('click', function(e) {
		addPaginationListeners(id);
	});
}

$(function() {
	qqStickers();
	markComments();
	$('comtbox5 ul.pagination li a').on('click', function(e) {
		addPaginationListeners('#' + $(this).parents('.comtbox5')[0].id);
	});
	addEmojioneArea();
	addCopyButtons();
	highlightAndCopyButtons();
});
