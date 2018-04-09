<div class='meta'>
	<ul class='data'>
		<li class='meta-author'>
			<span class='meta-label'>By</span>
			<a href='/?author={{$article->user->id}}' rel='author'>{{$article->user->name}}</a>
		</li>
		<li class='meta-date'>
			<span class='meta-label'>Posted on</span>
			{{$article->published_on}}
		</li>
		<li class='meta-categories'>
			<span class='meta-label'>Category</span>
			@if($article->category)
			{{$article->category->title}}
			@else
			Uncategorized
			@endif
		</li>
	</ul>
</div>