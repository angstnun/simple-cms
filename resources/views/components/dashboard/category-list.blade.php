@if(!$categories->isEmpty())
<ul id='category-list'>
	@for($i=0;$i<count($categories);$i++)
	<li>{{$categories[$i]->title}}<input type='hidden' name="category-list[{{$i}}][id]" value="{{$categories[$i]->id}}"><button onclick='removeListItem(event)'>Delete item</button>
	<br/>
	<div class='category-display-style'>
		<div>
			@if($categories[$i]->category_display_type_id == 1)
			<input type='radio' value='1' name='category-list[{{$i}}][displayStyle]' checked>
			<label>Rows</label>
			@else
			<input type='radio' value='1' name='category-list[{{$i}}][displayStyle]'>
			<label>Rows</label>
			@endif
		</div>
		<div>
			@if($categories[$i]->category_display_type_id == 2)
			<input type='radio' value='2' name='category-list[{{$i}}][displayStyle]' checked>
			<label>Columns</label>
			@else
			<input type='radio' value='2' name='category-list[{{$i}}][displayStyle]'>
			<label>Columns</label>
			@endif
		</div>
		<div>
			@if($categories[$i]->category_display_type_id == 3)
			<input type='radio' value='3' name='category-list[{{$i}}][displayStyle]' checked>
			<label>List</label>
			@else
			<input type='radio' value='3' name='category-list[{{$i}}][displayStyle]'>
			<label>List</label>
			@endif
		</div>
	</div>
	<br/>
	<div class='category-display-location'>
		<div>
			<input type='checkbox' value='true' name='category-list[{{$i}}][is_in_lnavbar]'
			@if($categories[$i]->is_in_lnavbar == true)
			checked>
			@else
			>
			@endif
			<label>Left navbar</label>
		</div>
		<div>
			<input type='checkbox' value='true' name='category-list[{{$i}}][is_in_rnavbar]'
			@if($categories[$i]->is_in_rnavbar == true)
			checked>
			@else
			>
			@endif
			<label>Right navbar</label>
		</div>
		<div>
			<input type='checkbox' value='true' name='category-list[{{$i}}][is_in_body]'
			@if($categories[$i]->is_in_body == true)
			checked>
			@else
			>
			@endif
			<label>Body</label>
		</div>
	</div>
	<br/>
	<div class='category-order'>
		@if($categories[$i]->is_ordered_asc == true)
		<div><input type='radio' value='true' name='category-list[{{$i}}][is_ordered_asc]' checked>
		<label>Ascending</label></div>
		<div><input type='radio' value='false' name='category-list[{{$i}}][is_ordered_asc]'>
		<label>Descending</label></div>
		@else
		<div><input type='radio' value='true' name='category-list[{{$i}}][is_ordered_asc]'>
		<label>Ascending</label></div>
		<div><input type='radio' value='false' name='category-list[{{$i}}][is_ordered_asc]' checked>
		<label>Descending</label></div>
		@endif
	</div>
	</li>
	@endfor
</ul>
@else
<ul id='category-list'>
</ul>
@endif