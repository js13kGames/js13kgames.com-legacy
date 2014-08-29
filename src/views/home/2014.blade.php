@extends('layouts.master')
@section('content')
<section id="home">
	<h2>What is js13kGames?</h2>
	<img class="logo" src="assets/img/logo.png" />
	<div class="description">
		<p><strong>Js13kGames</strong> is a JavaScript coding competition for <strong>HTML5 game developers</strong>. The fun part of the compo is the file size limit set to <strong>13&nbsp;kilobytes</strong>. Theme for 2014 is <strong>The Elements: Earth, Water, Air and Fire</strong>. The&nbsp;competition started at <strong>13:00 CEST, 13th August</strong> and will end at <strong>13:00 CEST, 13th September 2014</strong>. See the <a href="http://js13kgames.com/#rules">Rules</a> for details, good luck and <strong>have fun</strong>!</p>
		<p>The competition is organized by <a href="http://end3r.com">Andrzej Mazur</a> from <a href="http://enclavegames.com/">Enclave Games</a>.</p>
		<p class="social">
			<span><strong>Follow us on:</strong></span>
			<span><a href="http://twitter.com/js13kGames" class="twitter-follow-button" data-button="blue" data-text-color="#FFFFFF" data-link-color="#FFFFFF" data-show-screen-name="false" data-show-count="true">Follow @js13kGames</a></span>
			<span><iframe src="http://www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fjs13kGames&amp;send=false&amp;layout=button_count&amp;width=110&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=segoe+ui&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:20px;" allowTransparency="true"></iframe></span>
		</p>
	</div>
</section>

<section id="promo">
	<div class="donate">
		<img class="photo" src="assets/img/photo.png" />
		<h3>Hi, I'm Andrzej</h3>
		<p>I'm running this competition on my own in my free time. I acquired prizes worth around 18.000 USD and did get support from the sponsors, but depending on the number of submitted games I might not be able to send the usual <strong>js13k t-shirts to everybody</strong> which I secretly did in 2012 and 2013. If you want to help me sponsor the t-shirts and <strong>3,5 diskettes</strong> with the 2014 games for <strong>all of the participants</strong>, please send a few bucks via services below, thank you!</p>
		<img class="tshirt" src="assets/img/js13k-tshirt-2014.png" />
		<img class="diskette" src="assets/img/diskette.png" />
		<div class="donate-buttons">
			<form class="donate-paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_donations">
				<input type="hidden" name="business" value="andrzej.mazur@end3r.com">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="item_name" value="js13kGames 2014 t-shirts">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<a target="_blank" class="donate-gittip" href="https://www.gittip.com/end3r/" title="Gittip"><img src="assets/img/gittip.png" alt="Gittip" /></a>
			<a class="donate-flattr" href="https://flattr.com/submit/auto?user_id=end3r&url=http%3A%2F%2Fjs13kgames.com&title=js13kGames" target="_blank"><img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0"></a>
		</div>
	</div>
	<div class="newsletter" id="mc_embed_signup">
		<h3><a href="http://gamedevjsweekly.com/">Gamedev.js Weekly</a></h3>
		<h4>Weekly newsletter about HTML5 Game Development</h4>
		<form action="http://gamedevjs.us3.list-manage.com/subscribe/post?u=4ad274b490aa6da8c2d29b775&amp;id=bacab0c8ca" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Your email address" required>
			<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
			<input id="hidden-input" type="text" name="b_4ad274b490aa6da8c2d29b775_bacab0c8ca" value="">
		</form>
	</div>
	<div class="triska">
		<a target="_blank" href="http://13.enclavegames.com/"><img class="photo" src="assets/img/triska-banner.png" /></a>
	</div>
</section>

<section id="sponsors">
	<h2>Sponsors</h2>
	<a class="partner" href="http://www.spilgames.com/"><img src="assets/img/partners/2014/spilgames.png" alt="Spil Games"></a>
	<a class="partner" href="http://www.boostermedia.com/"><img src="assets/img/partners/2014/boostermedia.png" alt="Boostermedia"></a><br />
	<a class="partner" href="http://www.mozilla.org/"><img src="assets/img/partners/2014/mozilla.png" alt="Mozilla"></a>
	<h2>Supporters</h2>
	<a class="partner" href="https://github.com/"><img src="assets/img/partners/2014/github.png"></a>
	<p>Share the love for HTML5 games and support the js13kGames competition!<br />See the <a href="#contact">Contact</a> section for more details on how to get in touch.</p>
	<a class="up" href="/"></a>
</section>

<section id="judges">
	<h2>Judges</h2>
	<article class="judge" id="andrzej">
		<img src="assets/img/judges/2014/andrzej_mazur.png" alt="Andrzej Mazur" />
		<div>
			<h3>Andrzej Mazur</h3>
			<p>HTML5 Game Developer and JavaScript programmer, <a href="http://enclavegames.com/">Enclave Games</a> indie studio founder, <a href="http://gamedevjsweekly.com/">Gamedev.js Weekly</a> newsletter publisher, <a href="http://js13kgames.com/">js13kGames</a> competition creator and <a href="http://gamedevjs.com/">Gamedev.js Meetups</a> organizer. Developed <a href="http://enclavegames.com/games/captain-rogers/">Captain Rogers</a>, <a href="http://enclavegames.com/games/hungry-fridge/">Hungry Fridge</a>, <a href="http://enclavegames.com/games/full-immersion/">Full Immersion</a> and many other games. Firefox OS fan and sushi lover.
			<p class="judgeContact"><a href="https://twitter.com/end3r">@end3r</a> | <a href="http://end3r.com/">end3r.com</a></p>
		</div>
	</article>
	<article class="judge right" id="robbert">
		<img src="assets/img/judges/2014/robbert_van_os.png" alt="Robbert van Os" />
		<div>
			<h3>Robbert van Os</h3>
			<p>I am your friendly neighbourhood game developer evangelist from <a href="http://www.spilgames.com/">Spil Games</a>. My goal is to build communities around writing the best games possible, and providing the tools and knowledge to do so. Based in Europe, I’m the founder of <a href="http://www.html5united.com/">html5united.com</a> and active in the global games industry for over 12 years.</p>
			<p class="judgeContact"><a href="https://twitter.com/gamerhero">@gamerhero</a> | <a href="http://html5united.com/">html5united.com</a></p>
		</div>
	</article>
	<article class="judge" id="christer">
		<img src="assets/img/judges/2014/christer_kaitila.png" alt="Christer Kaitila" />
		<div>
			<h3>Christer Kaitila</h3>
			<p>Organizer of <a href="http://www.onegameamonth.com/">One Game A Month</a> and the <a href="http://www.charitygamejam.com/">Charity Game Jam</a>, editor at <a href="http://gamedev.tutsplus.com/">Gamedevtuts+</a>, and creator of <a href="http://mcfunkypants.com/">30 games</a>, <a href="http://soundcloud.com/McFunkypants">20 songs</a>, <a href="http://www.amazon.com/s/ref=ntt_athr_dp_sr_1?_encoding=UTF8&amp;field-author=Christer%20Kaitila&amp;search-alias=digital-text&amp;sort=relevancerank">2 books</a>, and an HTML5 <a href="https://github.com/Mcfunkypants/Ludus">platformer game starter kit</a>, McFunkypants is an optimist disco viking and child of the arcade era. He has been an indie gamedev for over a decade.</p>
			<p class="judgeContact"><a href="https://twitter.com/mcfunkypants">@mcfunkypants</a> | <a href="http://mcfunkypants.com/">mcfunkypants.com</a></p>
		</div>
	</article>
	<article class="judge right" id="elle">
		<img src="assets/img/judges/2014/elle_chen.png" alt="Elle Chen" />
		<div>
			<h3>Elle Chen</h3>
			<p>Elle Chen is the License Manager of <a href="http://www.boostermedia.com/">BoosterMedia Network B.V.</a>, the leading HTML5 game publisher. She has licensed hundreds of HTML5 games and also the initiator of <a href="http://www.doctorhtml5games.com/">DoctorHTML5games.com</a> blog.</p>
			<p class="judgeContact"><a href="https://twitter.com/elleycchen">@elleycchen</a> | <a href="http://linkedin.com/in/cutedogpie">linkedin.com/in/cutedogpie</a></p>
		</div>
	</article>
	<article class="judge" id="jason">
		<img src="assets/img/judges/2014/jason_weathersby.png" alt="Jason Weathersby" />
		<div>
			<h3>Jason Weathersby</h3>
			<p>Jason Weathersby is a Technical Evangelist for <a href="http://hacks.mozilla.org/">Mozilla</a>, evangelizing Firefox OS. He is also a committer on the BIRT project at the Eclipse Foundation. He is a proponent of HTML5, Open Source and all things related to web-based gaming.</p>
			<p class="judgeContact"><a href="https://twitter.com/JasonWeathersby">@JasonWeathersby</a></p>
		</div>
	</article>
	<article class="judge right" id="robert">
		<img src="assets/img/judges/2014/robert_podgorski.png" alt="Robert Podgórski" />
		<div>
			<h3>Robert Podgórski</h3>
			<p>Indie games creator. Maker of <a href="http://thefew.pl">The Few</a>, Captain Rogers Chronicles and some others. Addicted to ketchup.</p>
			<p class="judgeContact"><a href="https://twitter.com/blackmoondev">@blackmoondev</a> | <a href="http://blackmoondev.com/">blackmoondev.com</a></p>
		</div>
	</article>
	<article class="judge" id="michael">
		<img src="assets/img/judges/2014/michael_wales.png" alt="Michael Wales" />
		<div>
			<h3>Michael Wales</h3>
			<p>Michael Wales is the Web Dev Curriculum Manager at <a href="http://udacity.com/">Udacity</a>, building courses with industry partners like Google, Facebook and Twitter. Before joining Udacity, he developed web applications for the US Air Force, Defense Intelligence Agency and National Security Agency.</p>
			<p class="judgeContact"><a href="https://twitter.com/walesmd">@walesmd</a> | <a href="http://michaelwales.com/">michaelwales.com</a></p>
		</div>
	</article>
	<a class="up" href="/"></a>
</section>

<section id="prizes">
	<h2>Prizes</h2>
	<article class="prize" id="playcanvas">
		<img src="assets/img/prizes/2014/playcanvas.png" alt="Playcanvas" />
		<div>
			<h3>10 &times; PlayCanvas Pro account</h3>
			<p>Ten 12-month <a href="http://playcanvas.com/">PlayCanvas</a> Pro accounts offering cloud-hosted, collaborative platform for building video games.</p>
		</div>
	</article>
	<article class="prize" id="construct2">
		<img src="assets/img/prizes/2014/construct2.png" alt="Construct 2" />
		<div>
			<h3>5 &times; Construct 2 game engine</h3>
			<p>Five Personal Edition licenses for <a href="https://www.scirra.com/construct2">Construct 2</a> game engine created by <a href="https://www.scirra.com/">Scirra</a>.</p>
		</div>
	</article>
	<article class="prize" id="moneywithhtml5">
		<img src="assets/img/prizes/2014/moneywithhtml5.png" alt="Making money with HTML5" />
		<div>
			<h3>10 &times; Making Money with HTML5 ebook</h3>
			<p>Ten copies of <a href="http://www.truevalhalla.com/blog/ebook/">Making Money with HTML5</a> ebook by <a href="http://www.truevalhalla.com/">Matthew Bowden</a>.</p>
		</div>
	</article>
	<article class="prize" id="github">
		<img src="assets/img/prizes/2014/github.png" alt="GitHub" />
		<div>
			<h3>30 &times; GitHub 6 month medium account</h3>
			<p>Thirty paid <a href="https://github.com/">GitHub</a> plans - medium accounts for six months.</p>
		</div>
	</article>
	<article class="prize" id="blossom">
		<img src="assets/img/prizes/2014/blossom.png" alt="Blossom.io" />
		<div>
			<h3>1 &times; Blossom.io Enterprise account for 12 months</h3>
			<p>One Enterprise license for <a href="http://www.blossom.io/">Blossom.io</a>, agile project management tool.</p>
		</div>
	</article>
	<article class="prize" id="jetbrains">
		<img src="assets/img/prizes/2014/jetbrains.png" alt="JetBrains" />
		<div>
			<h3>7 &times; JetBrains product license</h3>
			<p>Seven licenses for one of the many various <a href="http://www.jetbrains.com/">JetBrains</a> professional development tools.</p>
		</div>
	</article>
	<article class="prize" id="discoverphaser">
		<img src="assets/img/prizes/2014/discoverphaser.png" alt="Discover Phaser" />
		<div>
			<h3>10 &times; Discover Phaser ebook</h3>
			<p>Learn how to make HTML5 games with <a href="http://discoverphaser.com/">Discover Phaser</a> ebook by <a href="http://lessmilk.com/">Thomas Palef</a>.</p>
		</div>
	</article>
	<article class="prize" id="impactjs">
		<img src="assets/img/prizes/2014/impactjs.png" alt="ImpactJS" />
		<div>
			<h3>5 &times; ImpactJS game engine</h3>
			<p>Five licenses for <a href="http://impactjs.com/">ImpactJS</a> game engine created by <a href="http://www.phoboslab.org/">Dominic Szablewski</a>.</p>
		</div>
	</article>
	<article class="prize" id="isogenic">
		<img src="assets/img/prizes/2014/isogenic.png" alt="Isogenic Engine" />
		<div>
			<h3>8 &times; Isogenic Engine premium license</h3>
			Eight premium licenses for <a href="http://www.isogenicengine.com/">Isogenic Game Engine</a> created by <a href="http://irrelon.com/">Irrelon Software</a>.</p>
		</div>
	</article>
	<article class="prize" id="protoio">
		<img src="assets/img/prizes/2014/protoio.png" alt="Proto.io" />
		<div>
			<h3>1 &times; Proto.io Startup account</h3>
			<p>One <a href="http://proto.io/">Proto.io</a> account with Startup plan for 12 months.</p>
		</div>
	</article>
	<article class="prize" id="clayio">
		<img src="assets/img/prizes/2014/clayio.png" alt="Clay.io" />
		<div>
			<h3>Advertisement on Clay.io</h3>
			<p>Winner of the Desktop category will be featured on the <a href="http://clay.io/">Clay.io</a> homepage and the Mobile winner on the mobile site.</p>
		</div>
	</article>
	<article class="prize" id="kendoui">
		<img src="assets/img/prizes/2014/kendoui.png" alt="Kendo UI Professional" />
		<div>
			<h3>2 &times; Kendo UI Professional</h3>
			<p>Two licenses for <a href="http://www.telerik.com/kendo-ui">Kendo UI Professional</a> for 6 months with upgrades and commercial support.</p>
		</div>
	</article>
	<article class="prize" id="thefew">
		<img src="assets/img/prizes/2014/thefew.png" alt="The Few" />
		<div>
			<h3>The Few game</h3>
			<p>Unlimited copies of <a href="http://thefew.pl/">The Few</a> game by <a href="http://blackmoondev.com/">Blackmoon Design</a>, one for <strong>every participant</strong> (or team) in the competition.</p>
		</div>
	</article>
	<article class="prize" id="mcpixel">
		<img src="assets/img/prizes/2014/mcpixel.png" alt="McPixel" />
		<div>
			<h3>McPixel game</h3>
			<p>Unlimited copies of the <a href="http://mcpixel.net/">McPixel</a> game by <a href="http://sos.gd/">Sos Sosowski</a>, one for <strong>every participant</strong> (or team) in the competition.</p>
		</div>
	</article>
	<article class="prize" id="qbqbqb">
		<img src="assets/img/prizes/2014/qbqbqb.png" alt="QbQbQb" />
		<div>
			<h3>QbQbQb game</h3>
			<p>Unlimited copies of the <a href="http://qbqbqb.rezoner.net/">QbQbQb</a> game by <a href="http://rezoner.net/">Rezoner Sikorski</a>, one for <strong>every participant</strong> (or team) in the competition.</p>
		</div>
	</article>
	<article class="prize" id="nodebb">
		<img src="assets/img/prizes/2014/nodebb.png" alt="NodeBB" />
		<div>
			<h3>5 &times; NodeBB hosting</h3>
			<p>Five Hamlet hosting plans for 12 months each from the <a href="https://nodebb.org/">NodeBB</a> team.</p>
		</div>
	</article>
	<a class="up" href="/"></a>
</section>
<section id="places">
	<h2>Places</h2>
	<section id="places-desktop">
		<h4>Desktop category</h4>
		<article class="place">
			<h3>1st place desktop</h3>
			<ul>
				<li><strong>Advertisement</strong> of the game on Clay.io</li>
				<li><strong>Software licenses</strong>: JetBrains product license, Construct 2 game engine, Isogenic Engine premium license</li>
				<li><strong>Accounts licenses</strong>: Kendo UI Complete for 1 year, PlayCanvas Pro account for 1 year, GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Discover Phaser</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>2nd place desktop</h3>
			<ul>
				<li><strong>Software licenses</strong>: JetBrains product license, Construct 2 game engine, Isogenic Engine premium license</li>
				<li><strong>Accounts licenses</strong>: PlayCanvas Pro account for 1 year, GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Discover Phaser</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>3rd place desktop</h3>
			<ul>
				<li><strong>Software licenses</strong>: Construct 2 game engine, Isogenic Engine premium license</li>
				<li><strong>Accounts licenses</strong>: PlayCanvas Pro account for 1 year, GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Discover Phaser</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>4th-5th places desktop</h3>
			<ul>
				<li><strong>Software licenses</strong>: Isogenic Engine premium license</li>
				<li><strong>Accounts licenses</strong>: PlayCanvas Pro account for 1 year, GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Discover Phaser</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>6th-10th places desktop</h3>
			<ul>
				<li><strong>Accounts licenses</strong>: GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Discover Phaser</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
	</section>
	<section id="places-mobile">
		<h4>Mobile category</h4>
		<article class="place">
			<h3>1st place mobile</h3>
			<ul>
				<li><strong>Advertisement</strong> of the game on Clay.io</li>
				<li><strong>Software licenses</strong>: ImpactJS game engine, Construct 2 game engine, JetBrains product license</li>
				<li><strong>Accounts licenses</strong>: PlayCanvas Pro account for 1 year, GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Making money with HTML5</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>2nd place mobile</h3>
			<ul>
				<li><strong>Software licenses</strong>: ImpactJS game engine, JetBrains product license</li>
				<li><strong>Accounts licenses</strong>: GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Making money with HTML5</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>3rd-5th places mobile</h3>
			<ul>
				<li><strong>Software licenses</strong>: ImpactJS game engine</li>
				<li><strong>Accounts licenses</strong>: GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Making money with HTML5</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>6th-10th places mobile</h3>
			<ul>
				<li><strong>Accounts licenses</strong>: GitHub 6 month medium account</li>
				<li><strong>eBook</strong>: Making money with HTML5</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
	</section>
	<section id="places-server">
		<h4>Server category</h4>
		<article class="place">
			<h3>1st place server</h3>
			<ul>
				<li><strong>Software licenses</strong>: Construct 2 game engine</li>
				<li><strong>Accounts licenses</strong>: PlayCanvas Pro account for 1 year</li>
				<li><strong>Hosting</strong>: NodeBB</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
		<article class="place">
			<h3>2nd-5th places server</h3>
			<ul>
				<li><strong>Hosting</strong>: NodeBB</li>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
	</section>
	<section id="places-special">
		<h4>Specials</h4>
		<article class="place">
			<h3>Twitter Specials <span>(for the highest number of tweets)</span></h3>
			<ul>
				<li><strong>1st place</strong>: Proto.io Startup account, Isogenic Engine premium license, GitHub 6 month medium account</li>
				<li><strong>2nd place</strong>: JetBrains product license, GitHub 6 month medium account</li>
				<li><strong>3rd place</strong>: PlayCanvas Pro account, GitHub 6 month medium account</li>
			</ul>
		</article>
		<article class="place">
			<h3>Facebook Specials <span>(for the highest number of likes)</span></h3>
			<ul>
				<li><strong>1st place</strong>: Blossom.io Enterprise account for 12 months, Isogenic Engine premium license, GitHub 6 month medium account</li>
				<li><strong>2nd place</strong>: JetBrains product license, GitHub 6 month medium account</li>
				<li><strong>3rd place</strong>: PlayCanvas Pro account, GitHub 6 month medium account</li>
			</ul>
		</article>
		<article class="place">
			<h3>Google+ Specials <span>(for the highest number of +1's)</span></h3>
			<ul>
				<li><strong>1st place</strong>: Kendo UI Professional, Isogenic Engine premium license, GitHub 6 month medium account</li>
				<li><strong>2nd place</strong>: JetBrains product license, GitHub 6 month medium account</li>
				<li><strong>3rd place</strong>: PlayCanvas Pro account, GitHub 6 month medium account</li>
			</ul>
		</article>
		<article class="place" id="prizes-everybody">
			<h3>Prizes for every participant</h3>
			<ul>
				<li><strong>Games</strong>: The Few, McPixel, QbQbQb</li>
			</ul>
		</article>
	</section>
	<a class="up" href="/"></a>
</section>

<section id="categories" style="text-align: center;">
	<h2>Categories</h2>
	<p>There will be <strong>three different categories</strong> with <strong>top 10 games</strong> in every category.<br />You can submit your game to any of the categories - it's up to you.</p>
	<p>There will also be a <strong>Twitter</strong>, <strong>Facebook</strong> and <strong>Google+ Specials</strong> just like a year and two ago.</p>
	<article class="prize">
		<img src="assets/img/category-desktop.png" style="width: 150px; height: 150px;" alt="Prize" />
		<div>
			<h3>Desktop</h3>
			<p>Full power of the hardware.</p>
		</div>
	</article>
	<article class="prize">
		<img src="assets/img/category-mobile.png" style="width: 150px; height: 150px;" alt="Prize" />
		<div>
			<h3>Mobile</h3>
			<p>Mobile touch devices.</p>
		</div>
	</article>
	<article class="prize">
		<img src="assets/img/category-server.png" style="width: 150px; height: 150px;" alt="Prize" />
		<div>
			<h3>Server</h3>
			<p>Node.js multiplayer.</p>
		</div>
	</article>
	<a class="up" href="/"></a>
</section>

<section id="rules">
	<h2>Rules</h2>
	<article class="rule">
		<h3>Package size below 13 kB</h3>
		<p>All your code and game assets should be smaller than or equal to 13 kilobytes (that's exactly 13,312 bytes, because of 13 x 1024) when zipped. Your package should contain index.html file and when unzipped should work in the browser.</p>
	</article>
	<article class="rule">
		<h3>Two sources - readable and compressed</h3>
		<p>The competition is focusing on the package size, but learning from others is also very important. Please provide two sources of your game - first one should be minified and zipped to fit in the 13 kB limit (sent via the form) and the second one should be in a readable form with descriptive variable names and comments (hosted on GitHub).</p>
	</article>
	<article class="rule">
		<h3>No external libraries or services</h3>
		<p>You can't use any libraries, images or data files hosted on server or services that provide any type of data (for example Google Fonts are not allowed). Your game should work offline (Desktop and Mobile categories, not applicable to Server) and all the game assets should fit in the package(s) size limit. If you manage to shrink your favorite library below 13 kilobytes including the code itself, then you can use whatever you want, just remember about the 13 kB limit.</p>
	</article>
	<article class="rule">
		<h3>Main theme - The Elements: Earth, Water, Air and Fire</h3>
		<p>The main theme of the competition in 2014 is The Elements: Earth, Water, Air and Fire. It is optional, so you can use it, use part of it (one Element), or drop it. Remember that there will be bonus points for implementing the theme in your game.</p>
	</article>
	<article class="rule">
		<h3>Deadline - 13th September 2014</h3>
		<p>The competition starts at 13:00 CEST, 13th August 2014 and ends at 13:00 CEST, 13th September 2014. No submissions will be accepted after the end of the competition.</p>
	</article>
	<article class="rule">
		<h3>Licensing</h3>
		<p>You have to have the rights for every asset used in your game. Remember that the submitted games will be published and made available for everybody to see.</p>
	</article>
	<article class="rule">
		<h3>New content only</h3>
		<p>Do not submit any old games or demos - you have a whole month to work on something new and fresh, this should be more than enough.</p>
	</article>
	<article class="rule">
		<h3>Errors and browser support</h3>
		<p>Your game must work in at least one browser. The more supported browsers, the better - you can get more points for that. There should be no errors - you can lose some points if your game is showing any errors in the console. If we cannot play your game, it won't be accepted. You'll get extra points if your game supports any mobile devices.</p>
	</article>
	<article class="rule">
		<h3>Teams</h3>
		<p>It doesn't matter if you're working alone or with your friends, just remember that the number of prizes is fixed, so you'll have to share your trophies with your teammates.</p>
	</article>
	<article class="rule">
		<h3>Sending submissions</h3>
		<p>There will be a special form to submit your game. Please remember that you have to provide two sources (see the Rule #2 for details) - a link to a public repository on Github and a zipped package. Participants are allowed to submit more than one game in the competition.</p>
	</article>
	<article class="rule">
		<h3>Accepting submissions</h3>
		<p>Submissions will be checked manually and published after positive verification. This may take up to a couple of days, so be patient if your game is not yet online. I claim the right to reject any submission without giving a reason, although I hope I don't have to. I also have the right to update the rules of the competition at any time.</p>
	</article>
	<article class="rule" id="server">
		<h3>Server category specific rules</h3>
		<dl>
			<dt>Sandbox server</dt>
			<dd>You can find the official sandbox server at <a href="https://github.com/aurium/js-game-server">github.com/aurium/js-game-server</a> - it is maintained by Aurélio A. Heckert and Florent Cailhol.</dd>
			<dt>Package size still below 13 kB</dt>
			<dd>In this year one game package will contain all the game code and assets, for the client and the server.</dd>
			<dt>Sandboxed environment</dt>
			<dd>Your game will run in a node.js based sandbox environment. That means you will not really use node. You can require a limited collection of modules and your own modules shipped by your 13k pack.</dd>
			<dt>The allowed modules are:</dt>
			<dd>Assert, buffer, events, path, querystring, string_decoder, sandbox-io (a shimed version of socket.io already listening your game port) and sandbox-server (a shimed version of http.server already listening on your game port).</dd>
			<dt>Do not leak the sandbox</dt>
			<dd>This is not a hacking competition. This is a way to help the competition admins, the site persistence, and you. Trying to directly write files, to read files outside of your package, to use not allowed modules, to change the server port, or any other tries to leak the sandbox will cast you out of the competition.</dd>
			<dt>Yes, you can persist some data</dt>
			<dd>The sandbox has a global function "db(key[,value])". That can abstract the read/write json data from the disk for you.</dd>
			<dt>Socket.io client lib</dt>
			<dd>You can use it. Simply add &lt;script src="/socket.io/socket.io.js"&gt;&lt;/script&gt; to your HTML and that will be loaded. No server configuration will be needed. The sandbox already did it.</dd>
			<dt>Respect your neighbours</dt>
			<dd>Besides the fact that you can be cast out if you deliberately affect another game by accessing files or it's server, you also have to try to not plunder the host computing resources. That is also needed to preserve the server health.</dd>
			<dt>Can I test the sandbox before submitting?</dt>
			<dd>Yes, you can and you must! Installing and getting it running is simple. Visit the project page at <a href="https://github.com/aurium/js-game-server">github.com/aurium/js-game-server</a>.</dd>
			<dt>Is there any example? How do I develop my game using the sandbox server?</dt>
			<dd>Read the <a href="https://github.com/aurium/js-game-server/wiki/Writing-a-game">how to</a> and the <a href="https://github.com/aurium/js-game-server/tree/master/examples/pong">example</a> to learn more. Feel free to ask questions if you have any.</dd>
		</dl>
	</article>
	<article class="rule" id="faq">
		<h3>Frequently Asked Questions</h3>
		<dl>
			<dt>Why exactly 13 kB?</dt>
			<dd>Well... why not? :)</dd>
			<dt>What's in it for you? Are you getting paid?</dt>
			<dd>Nope, it's just my own idea and it's made for pure fun. I'd love to get a sponsorship though as I spent my own private money on the first edition to cover shipping of the prizes worldwide, making t-shirts etc.</dd>
			<dt>What does the "zipped" term exactly mean?</dt>
			<dd>Sent package should be zipped with your usual system archiver, the only allowed extension is .zip. Let's keep it simple - it's a competition for coders and this should be your main focus, the code itself. Thanks to the zipped archive you will easily send your game and we will easily check the file size.</dd>
			<dt>Can I use Flash?</dt>
			<dd>No, you can code your game using only the open web technologies like JavaScript, HTML and CSS.</dd>
			<dt>Can I use WebGL?</dt>
			<dd>Yes, though it might be hard to fit it into 13 kilobytes if you plan on doing an FPS game.</dd>
			<dt>Can I use CoffeeScript or TypeScript?</dt>
			<dd>Yes, you can use it, but you can't submit it. Only pure JavaScript code will be accepted, so remember to have your compiled code within the 13 kB limit.</dd>
			<dt>Can I use compression through the self-extracting PNGs?</dt>
			<dd>No, this technique is strictly prohibited. Only pure JavaScript minifying is allowed.</dd>
			<dt>More questions?</dt>
			<dd>Send them in <a href="#contact">via email or social media</a> or post them in the dedicated topic at the <a href="http://www.html5gamedevs.com/topic/7767-js13kgames-competition-2014/">HTML5GameDevs forums</a>.</dd>
		</dl>
	</article>
	<a class="up" href="/"></a>
</section>

<section id="contact">
	<h2>Contact</h2>
	<p>If You have any questions or propositions please feel free to contact us via e-mail: <span>contact@js13kgames.com</span>.<br />The other options include visiting our profiles on <a href="http://twitter.com/js13kgames">Twitter</a> or <a href="http://facebook.com/js13kgames">Facebook</a> and sending us the private message.</p>
	<a class="up" href="/"></a>
</section>
</div>
@stop