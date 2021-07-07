<?php
	requireLib('shjs');
	requireLib('mathjax');
	echoUOJPageHeader(UOJLocale::get('help')) 
?>
<article>
	<header>
		<h2 class="page-header">常见问题及其解答(FAQ)</h2>
	</header>
	<section>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerOne" data-toggle="collapse" data-target="#collapseOne" style="cursor:pointer;">
				<h5 class="mb-0">什么是 <?= UOJConfig::$data['profile']['oj-name-short'] ?></h5>
			</div>
			<div id="collapseOne" class="collapse">
				<div class="card-body">
					<p>来了？坐，欢迎来到 <?= UOJConfig::$data['profile']['oj-name'] ?>。</p>
					<p><img src="/images/utility/qpx_n/b37.gif" alt="小熊像超人一样飞" /></p>
					<p>众所周知，信息学的题目一般形式为：给出 XXXXX，要你提交一份源代码，输出 XXXXX，然后时限若干秒，内存若干兆，数据若干组，每组数据与答案进行比较，不对就不给分。</p>
					<p>看起来挺合理的，但是总是有意外。比如要求输出一个浮点数，与答案接近就满分。于是只好引入 Special Judge 来判断选手输出的正确性。</p>
					<p>但是还是有意外，比如提交两个程序，一个压缩另一个解压；比如提交答案题只用提交文件；比如给出音乐要求识别乐器，达到 90% 的正确率就算满分……</p>
					<p>这个时候 UOJ 出现了，于是 <?= UOJConfig::$data['profile']['oj-name-short'] ?> 就使用了这套系统。Universal 的中文意思是通用，之所以称之为 UOJ，因为我们所有题目从编译、运行到评分，都可以由出题人自定义。</p>
					<p>如果你正在为没有地方测奇奇怪怪的题目而苦恼，那么你来对地方了。</p>
					<p>当然了，<?= UOJConfig::$data['profile']['oj-name-short'] ?> 对于传统题的评测也做了特别支持。平时做题时我很难容忍的地方就是数据出水了导致暴力得了好多分甚至过了，而出题人却委屈地说，总共才一百分，卡了这个暴力就不能卡另一个暴力，所以暴力过了就过了吧。</p>
					<p>所以我们引入了 Extra Tests 和 Hack 机制。每道传统题的数据都分为 Tests 和 Extra Tests，Tests 满分 100 分，如果你通过了所有的 Tests，那么就会为你测 Extra Tests。如果过了 Tests 但没过 Extra Tests 那么倒扣 3 分变为 97 分。Extra Tests 的来源，一个是这道题没什么人可能会错的边界情况可以放在里面，另一个就是各位平时做题的时候，如果发现错误算法 AC 了，可以使用 hack 将其卡掉，<?= UOJConfig::$data['profile']['oj-name-short'] ?> 会自动加入 Extra Tests 并重测。我们无法阻止暴力高分的脚步，但是不让他得满分还是有心里安慰作用的～</p>
					<p><?= UOJConfig::$data['profile']['oj-name-short'] ?> 还有比赛功能可以承办比赛，赛制暂时只支持 OI 赛制。（不过你可以利用现有方案变相实现 ACM 赛制！）未来将支持更多种多样的赛制甚至自定义赛制。</p>
					<p>目前 <?= UOJConfig::$data['profile']['oj-name-short'] ?> 刚刚起步，还有很多地方有待完善。想出题、想出比赛、发现 BUG、发现槽点都可以联系我们，联系方式见下。</p>
					<p>祝各位在 <?= UOJConfig::$data['profile']['oj-name-short'] ?> 玩得愉快！（求不虐萌萌哒服务器～求不虐萌萌哒测评机～！）</p>
					<p><img src="/images/utility/qpx_n/b54.gif" alt="小熊抱抱" /></p>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerTwo" data-toggle="collapse" data-target="#collapseTwo" style="cursor:pointer;">
				<h5 class="mb-0">注册后怎么上传头像</h5>
			</div>
			<div id="collapseTwo" class="collapse">
				<div class="card-body">
					<p><?= UOJConfig::$data['profile']['oj-name-short'] ?> 不提供头像存储服务。每到一个网站都要上传一个头像挺烦的对不对？我们支持 Gravatar，请使用 Gravatar 吧！Gravatar 是一个全球的头像存储服务，你的头像将会与你的电子邮箱绑定。在各大网站比如各种 Wordpress 还有各种 OJ 比如 Vijos、Contest Hunter 上，只要你电子邮箱填对了，那么你的头像也就立即能显示了！</p>
					<p>快使用 Gravatar 吧！ Gravatar 地址：<a href="https://cn.gravatar.com/">https://cn.gravatar.com/</a>。进去后注册个帐号然后与邮箱绑定并上传头像，就 ok 啦！</p>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerThree" data-toggle="collapse" data-target="#collapseThree" style="cursor:pointer;">
				<h5 class="mb-0"><?= UOJConfig::$data['profile']['oj-name-short'] ?> 的测评环境？</h5>
			</div>
			<div id="collapseThree" class="collapse">
				<div class="card-body">
					<p>默认的测评环境是 Ubuntu Linux 18.04 LTS x64。</p>
					<p>C 的编译器是 gcc 7.4.0，编译命令：<code>gcc code.c -o code -lm -O2 -DONLINE_JUDGE</code>。</p>
					<p>C++ 的编译器是 g++ 7.4.0，编译命令：<code>g++ code.cpp -o code -lm -O2 -DONLINE_JUDGE</code>。如果选择 C++11 会在编译命令后面添加<code>-std=c++11</code>。</p>
					<p>Java8 的 JDK 版本是 openjdk 1.8.0_212，编译命令：<code>javac code.java</code>。</p>
					<p>Java11 的 JDK 版本是 openjdk 11.0.3，编译命令：<code>javac code.java</code>。</p>
					<p>Pascal 的编译器是 fpc 3.0.4，编译命令：<code>fpc code.pas -O2</code>。</p>
					<p>Python 会先编译为优化过的字节码 <samp>.pyo</samp> 文件。支持的 Python 版本分别为 Python 2.7 和 3.6。</p>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerFour" data-toggle="collapse" data-target="#collapseFour" style="cursor:pointer;">
				<h5 class="mb-0">各种评测状态的鸟语是什么意思？</h5>
			</div>
			<div id="collapseFour" class="collapse">
				<div class="card-body">
					<ul>
						<li>Accepted: 答案正确。恭喜大佬，您通过了这道题。</li>
						<li>Wrong Answer: 答案错误。仅仅通过样例数据的测试并不一定是正确答案，一定还有你没想到的地方。</li>
						<li>Runtime Error: 运行时错误。像非法的内存访问，数组越界，指针漂移，调用禁用的系统函数都可能出现这类问题，请点击评测详情获得输出。</li>
						<li>Time Limit Exceeded: 时间超限。请检查程序是否有死循环，或者应该有更快的计算方法。</li>
						<li>Memory Limit Exceeded: 内存超限。数据可能需要压缩，或者您数组开太大了，请检查是否有内存泄露。</li>
						<li>Output Limit Exceeded: 输出超限。你的输出居然比正确答案长了两倍！</li>
						<li>Dangerous Syscalls: 危险系统调用，你是不是带了文件，或者使用了某些有意思的 system 函数？</li>
						<li>Judgement Failed: 评测失败。可能是评测机抽风了，也可能是服务器正在睡觉；反正不一定是你的锅啦！</li>
						<li>No Comment: 没有详情。评测机对您的程序无话可说，那么我们也不知道到底发生了什么...</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerFive" data-toggle="collapse" data-target="#collapseFive" style="cursor:pointer;">
				<h5 class="mb-0">递归 10<sup>7</sup> 层怎么没爆栈啊</h5>
			</div>
			<div id="collapseFive" class="collapse">
				<div class="card-body">
					<p>没错就是这样！除非是特殊情况，<?= UOJConfig::$data['profile']['oj-name-short'] ?> 测评程序时的栈大小与该题的空间限制是相等的！</p>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerSix" data-toggle="collapse" data-target="#collapseSix" style="cursor:pointer;">
				<h5 class="mb-0">我在本地/某某 OJ 上 AC 了，但在 <?= UOJConfig::$data['profile']['oj-name-short'] ?> 却过不了...这咋办？</h5>
			</div>
			<div id="collapseSix" class="collapse">
				<div class="card-body">
					<p>对于这类问题，我们在这里简单列一下可能原因：</p>
					<ul>
						<li>Linux 中换行符是 '\n' 而 Windows 中是 '\r\n'（多一个字符）。有些数据在 Windows 下生成，而 <?= UOJConfig::$data['profile']['oj-name-short'] ?> 评测环境为 Linux 系统。这种情况在字符串输入中非常常见。当然，输出时是不会存在这个问题的。</li>
						<li>评测系统建立在 Linux 下，可能由于使用了 Linux 的保留字而出现 CE，但在 Windows 下正常。</li>
						<li>Linux 对内存的访问控制更为严格，因此在 Windows 上可能正常运行的无效指针或数组下标访问越界，在评测系统上无法运行。</li>
						<li>严重的内存泄露的问题很可能会引起系统的保护模块杀死你的进程。因此，凡是使用 malloc (或 calloc, realloc, new) 分配而得的内存空间，请使用 free (或 delete) 完全释放。</li>
						<li>当然数据可能真的有问题。但是如果不止一个人通过了这道题，那最好不要怀疑是数据的锅。反之，可以立即联系我们上报！</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerSeven" data-toggle="collapse" data-target="#collapseSeven" style="cursor:pointer;">
				<h5 class="mb-0">博客使用指南</h5>
			</div>
			<div id="collapseSeven" class="collapse">
				<div class="card-body">
					<p><?= UOJConfig::$data['profile']['oj-name-short'] ?> 博客使用的是 Markdown。（好吧……好简陋的……好多功能还没写……）</p>
					<p>（喂喂喂我们是 OJ 好吗……要那么完善的博客功能干啥呢……？）</p>
					<p>其实我觉得 Markdown 不用教！一学就会！</p>
					<p>（完蛋了……<?= UOJConfig::$data['profile']['oj-name-short'] ?> 好像没有 Markdown 的语法高亮……= =……）</p>
					<p>我就只介绍最基本的功能好了。其它的自己探索吧～比如<a href="http://wow.kuapp.com/markdown/">这里</a>。</p>
					<!-- readmore -->
					<p><code>**强调**</code> = <strong>强调</strong></p>
					<hr /><p><code>*强调*</code> = <em>强调</em></p>
					<hr /><p><code>[<?= UOJConfig::$data['profile']['oj-name-short'] ?>](<?= HTML::url('/') ?>)</code> = <a href="<?= HTML::url('/') ?>"><?= UOJConfig::$data['profile']['oj-name-short'] ?></a></p>
					<hr /><p><code><?= HTML::url('/') ?></code> = <a href="http://<?= UOJConfig::$data['web']['main']['host'] ?>"><?= HTML::url('/') ?></a></p>
					<hr /><p><code>![这个文字在图挂了的时候会显示](<?= HTML::url('/images/favicon.ico') ?>)</code> =
					<img src="<?= HTML::url('/images/favicon.ico') ?>" alt="这个文字在图挂了的时候会显示" /></p>
					<hr /><p><code>`rm orz`</code> = <code>rm orz</code></p>
					<hr /><p><code>数学公式萌萌哒 $(a + b)^2$ 萌萌哒</code> = 数学公式萌萌哒 $(a + b)^2$ 萌萌哒</p>
					<hr /><p><code>&lt;!-- readmore --&gt;</code> = 在外面看这篇博客时会到此为止然后显示一个“阅读更多”字样</p>
					<hr /><p>来个更大的例子：</p>
					<pre>
					```c++
					#include &lt;iostream&gt;
					```

					```c
					#include &lt;stdio.h&gt;
					```

					```pascal
					begin
					```

					```python
					print '<?= UOJConfig::$data['profile']['oj-name-short'] ?>'
					```

					\begin{equation}
					\frac{-b + \sqrt{b^2 - 4ac}}{2a}
					\end{equation}

					# 一级标题
					## 二级标题
					### 三级标题
					#### 四级标题
					</pre>
					<p>会转换为：</p>
					<pre><code class="sh_cpp">#include &lt;iostream&gt;</code></pre>
					<pre><code class="sh_c">#include &lt;stdio.h&gt;</code></pre>
					<pre><code class="sh_pascal">begin</code></pre>
					<pre><code class="sh_python">print '<?= UOJConfig::$data['profile']['oj-name-short'] ?>'</code></pre>
					<p>\begin{equation}
					\frac{-b + \sqrt{b^2 - 4ac}}{2a}
					\end{equation}</p>
					<h1>一级标题</h1>
					<h2>二级标题</h2>
					<h3>三级标题</h3>
					<h4>四级标题</h4>
					<hr /><p>还有一个很重要的事情，就是你很容易以为 <?= UOJConfig::$data['profile']['oj-name-short'] ?> 在吃换行……</p>
					<p>那是因为跟 LaTeX 一样，你需要一个空行来分段。你可以粗略地认为两个换行会被替换成一换行。（当然不完全是这样，空行是用来分段的，段落还有间距啊行首空两格啊之类的属性，真正的换行而不分段是在行末加上两个空格。）</p>
					<p>唔……就介绍到这里吧。想要更详细的介绍上网搜搜吧～</p>
					<p>（评论区是不可以用任何 HTML 滴～但是数学公式还是没问题滴）</p>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerEight" data-toggle="collapse" data-target="#collapseEight" style="cursor:pointer;">
				<h5 class="mb-0">如何使用题解/讨论？</h5>
			</div>
			<div id="collapseEight" class="collapse">
				<div class="card-body">
					<p>题解和讨论是 Hinata Online Judge 新增的 feature。在博客中加上标签 <samp>tutorial</samp>/<samp>discuss</samp> 以及对应的题号就可以啦！</p>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerNine" data-toggle="collapse" data-target="#collapseNine" style="cursor:pointer;">
				<h5 class="mb-0">交互式类型的题怎么本地测试</h5>
			</div>
			<div id="collapseNine" class="collapse">
				<div class="card-body">
					<p>唔……好问题。交互式的题一般给了一个头文件要你 include 进来，以及一个实现接口的源文件 grader。好像大家对多个源文件一起编译还不太熟悉。</p>
					<p>对于 C++：<code>g++ -o code grader.cpp code.cpp</code></p>
					<p>对于 C 语言：<code>gcc -o code grader.c code.c</code></p>
					<p>如果你是悲催的电脑盲，实在不会折腾没关系！你可以把 grader 的文件内容完整地粘贴到你的 code 的 include 语句之后，就可以了！</p>
					<p>什么你是萌萌哒 Pascal 选手？一般来说都会给个 grader，你需要写一个 Pascal 单元。这个 grader 会使用你的单元。所以你只需要把源文件取名为单元名 + <code>.pas</code>，然后：</p>
					<p>对于 Pascal 语言：<code>fpc grader.pas</code></p>
					<p>就可以啦！</p>
				</div>
			</div>
		</div>
		<div class="card my-1">
			<div class="card-header collapsed" id="headerTen" data-toggle="collapse" data-target="#collapseTen" style="cursor:pointer;">
				<h5 class="mb-0">联系方式</h5>
			</div>
			<div id="collapseTen" class="collapse">
				<div class="card-body">
					<p>如果你刚刚注册，或者想出题、想办比赛、发现了 BUG、对网站有什么建议，可以通过下面的方式联系我们：</p>
					<ul>
						<li>email: ouuansteve@163.com 或者用其它方式联系 ouuan</li>
						<li>直接在机房里找或者通过其它方式联系当前的 OJ 管理员或者 song8448</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
</article>

<?php echoUOJPageFooter() ?>
