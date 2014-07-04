<section id="submit">

	@foreach($errors->all('<p class="message error"><b>Error!</b> :message</p>') as $error)
		{{ $error }}
	@endforeach

	<h2>Submit Form</h2>
	<article class="form">
		<h3>Read the <a href="/#rules">Rules</a> first before submitting your game!</h3>
		<form action="/submit" method="post" enctype="multipart/form-data">
			<input type="hidden" name="token" value="{{ $form['token'] }}" />
			<p>
				<label for="nick" class="required">Name &frasl; nick:</label>
				<input id="nick" class="text" type="text" name="author" maxlength="50" value="{{ isset($submission) ? $submission->author : '' }}" required />
			</p>
			<p>
				<label for="twitter">Twitter username:</label>
				<input id="twitter" class="text" type="text" name="twitter" placeholder="without the @" maxlength="50" value="{{ isset($submission) ? $submission->twitter : '' }}" />
			</p>
			<p>
				<label for="website">Your website:</label>
				<input id="website" class="text" type="text" placeholder="http://" name="website_url" maxlength="200" value="{{ isset($submission) ? $submission->website_url : '' }}" />
			</p>
			<p>
				<label for="email" class="required">E-mail address <span>(won't be published)</span>:</label>
				<input id="email" class="text" type="email" name="email" maxlength="100" value="{{ isset($submission) ? $submission->email : '' }}" required />
			</p>
			<p>
				<label for="github" class="required">Link to the GitHub repository:</label>
				<input id="github" class="text" type="text" name="github_url" maxlength="200" placeholder="http://github.com/" value="{{ isset($submission) ? $submission->github_url : '' }}" required />
			</p>
			<p>
				<label for="server" class="optional">If using server-side JavaScript, provide a link to deployed game:</label>
				<input id="server" class="text optional" type="text" name="server_url" maxlength="200" value="{{ isset($submission) ? $submission->server_url : '' }}" />
			</p>
			<p>
				<label for="title" class="required">Title of the game:</label>
				<input id="title" class="text" type="text" name="title" maxlength="100" value="{{ isset($submission) ? $submission->title : '' }}" required />
			</p>
			<p>
				<label class="required">Categories:</label>
@if($i = 1)
@endif
@foreach($form['categories'] as $category)
				<span class="category"><input class="checkbox" id="cat_{{ $category->id }}" type="checkbox" name="categories[]" value="{{ $category->id }}"@if(++$i == 2) checked @endif /> {{ $category->title }}</span>
@endforeach
			</p>
			<p>
				<label for="description" class="required">Short game description:</label>
				<textarea id="description" class="text" name="description" cols="1" rows="1" required>{{ isset($submission) ? $submission->description : '' }}</textarea>
			</p>
			<p>
				<label for="file" class="required">Upload the .zip package:</label>
				<input type="file" name="file" id="file" accept="application/zip" required />
			</p>
			<p>
				<label for="file_server" class="optional">If using server-side JS, upload a .zip package with your server code:</label>
				<input type="file" name="file_server" id="file_server" accept="application/zip" />
			</p>
			<p>
				<label for="image1" class="required">Small screenshot (160px &times; 160px):</label>
				<input type="file" name="small_screenshot" id="image1" accept="image/*" required />
			</p>
			<p>
				<label for="image2" class="required">Big screenshot (400px &times; 250px):</label>
				<input type="file" name="big_screenshot" id="image2" accept="image/*" required />
			</p>
			<p class="bottom">
				<label for="spam" class="required">{{ $form['num'][0] }} + {{ $form['num'][1] }} = </label>
				<input type="text" id="spam" class="text" name="spam" size="2" />
				<abbr title="Spam protection">(?)</abbr>
			</p>
			<p class="bottom">
				<label for="submit" class="send">Let's do it!</label>
				<input type="submit" id="submit" name="formSubmit" class="submit" value="Submit" />
			</p>
		</form>
	</article>
	<a class="up" href="/"></a>
</section>