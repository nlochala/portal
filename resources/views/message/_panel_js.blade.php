{{--<script type="text/javascript">--}}

{{--    // Add Filepond initializer form.js.file--}}

{{--    jQuery(document).ready(function () {--}}
        @foreach($messages as $message)
        $('#message_{{ $message->id }}_link').click(function (event) {
            event.preventDefault();
            $.ajax({
                url: '/api/message/{{ $message->uuid }}/read',
                dataType: 'json',
                data: '',
                success: function (data) {
                    // Your Code here
                    if (data === true) {
                        if ($('#message_{{ $message->id }}_icon').hasClass('fa')) {
                            $('#message_{{ $message->id }}_icon')
                                .removeClass('fa fa-circle')
                                .addClass('si si-envelope-letter')
                                .css("color", "");
                        }
                    }
                }
            })
        });
        @endforeach

// Init Select2 - Basic Multiple
$("#class_id").select2({
placeholder: "Select one or more recipients...",
allowClear: true,
width: '100%'
});

var edit_element = $('#message_body-edit');
var input_element = $('#message_body');
var form_element = $('#admin-form');
var error_text = '<p><span style="color: rgb(224, 79, 26); font-size: 14px;">The message is required.</span></p>';

edit_element.summernote({
toolbar: [
['style'],
['style', ['bold', 'italic', 'underline', 'clear']],
['font', ['strikethrough', 'superscript', 'subscript']],
['para', ['ul', 'ol', 'paragraph']],
['insert', ['picture', 'link', 'video', 'table', 'hr']],
['misc', ['undo', 'redo', 'fullscreen', 'help']]
],
tabsize: 2,
height: 400,
dialogsInBody: true,
dialogsFade: true,
callbacks: {
onBlur: function () {
var content = edit_element.summernote('code');
input_element.val(content);
},
onFocus: function () {
var content = edit_element.summernote('code');
if(content == error_text){
edit_element.summernote('code', '');
}
}
}
});

form_element.on('submit', function (e) {
if (edit_element.summernote('isEmpty')) {
edit_element.summernote('code',error_text);
e.preventDefault();
}
});

// IF THERE IS EXISTING TEXT TO PASS THROUGH
text_data = '{!! old('message_body') ?? '' !!}';
edit_element.summernote('code', text_data);



{{--    });--}}
{{--</script>--}}
