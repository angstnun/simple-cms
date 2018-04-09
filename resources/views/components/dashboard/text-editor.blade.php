<script src='js/tinymce/tinymce.min.js'></script>
<script>

	//general

	tinymce.init({
	selector:'textarea', 
	height: 500, 
	plugins: [
		'image advlist autolink lists link charmap print preview anchor textcolor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table contextmenu paste code help wordcount'
	],
	menubar: 'false',
	toolbar: 'insert | undo redo | formatselect | sizeselect | fontselect | fontsizeselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
	init_instance_callback: function(editor) {
		console.log('Editor: ' + editor.id + ' is now initialized.'); 
	},
	setup: function(editor){
		editor.on('NodeChange', function(e) {
			if(e.element.tagName === 'IMG'){
				e.element.classList.add('img-responsive')
			}
		});
	},

	///image manager

	image_title: true,
	image_class_list: [
		{title: 'none', value: ''},
		{title: 'Left margin', value: 'img-margin-left'}
	],
	images_upload_url: 'imgUpload',
	automatic_uploads: false,
	file_picker_types: 'image',
	image_list: {{ $image_list }},
	});
</script>