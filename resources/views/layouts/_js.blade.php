{{--<!-- Dashmix Core JS -->--}}
<script src="{{ asset(mix('js/dashmix.app.js')) }}"></script>

{{--<!-- Laravel Scaffolding JS -->--}}
<script src="{{ asset(mix('js/laravel.app.js')) }}"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('js/plugins/cropperjs/cropper.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/datatables_select2.js') }}"></script>
<script src="{{ asset('js/plugins/multiselect/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/plugins/multiselect/jquery.quicksearch.js') }}"></script>



<!-- Algolia -->
<script src="{{ asset('js/plugins/algolia/algoliasearch.min.js') }}"></script>
<script src="{{ asset('js/plugins/algolia/autocomplete.min.js') }}"></script>

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<!-- Filepond -->
<script src="{{ asset('js/plugins/doka/doka.min.js') }}"></script>

<!-- Filepond -->
<script src="{{ asset('js/plugins/filepond/filepond.js') }}"></script>

<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-encode/filepond-plugin-file-encode.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-metadata/filepond-plugin-file-metadata.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-crop/filepond-plugin-image-crop.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-edit/filepond-plugin-image-edit.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-preview/filepond-plugin-image-preview.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-resize/filepond-plugin-image-resize.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-transform/filepond-plugin-image-transform.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-validate-size/filepond-plugin-image-validate-size.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/jquery-filepond/filepond.jquery.js') }}"></script>
<script src="{{ asset('js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>



<!-- Summernote Text Editor-->
<script src="{{ asset('js/plugins/summernote/summernote-bs4.min.js') }}"></script>


<script type="text/javascript">
    jQuery(function(){ Dashmix.helpers(['easy-pie-chart', 'sparkline']); });
    ///////////////////////////////////////////////////////
    // ALGOLIA
    ///////////////////////////////////////////////////////
    const client = algoliasearch("{{ env('ALGOLIA_APP_ID') }}", "{{ env('ALGOLIA_CLIENT_SEARCH') }}");
    const employees = client.initIndex('employees');
    const students = client.initIndex('students');
    const guardians = client.initIndex('guardians');

    autocomplete('#aa-search-input', {}, [
        {
            source: autocomplete.sources.hits(students, {hitsPerPage: 6}),
            displayKey: 'display_name',
            templates: {
                header: '<div class="aa-suggestions-category">STUDENTS</div>',
                suggestion({_highlightResult}) {
                    return `<span>${_highlightResult.display_name.value}</span><span>${_highlightResult.grade_level.value}</span>`;
                }
            }
        },
        {
            source: autocomplete.sources.hits(guardians, {hitsPerPage: 6}),
            displayKey: 'display_name',
            templates: {
                header: '<div class="aa-suggestions-category">GUARDIANS</div>',
                suggestion({_highlightResult}) {
                    return `<span>${_highlightResult.display_name.value}</span><span>${_highlightResult.email_school.value}</span>`;
                }
            }
        },
        {
            source: autocomplete.sources.hits(employees, {hitsPerPage: 6}),
            displayKey: 'display_name',
            templates: {
                header: '<div class="aa-suggestions-category">EMPLOYEES</div>',
                suggestion({_highlightResult}) {
                    return `<span>${_highlightResult.display_name.value}</span><span>${_highlightResult.email_school.value}</span>`;
                }
            }
        },
    ]).on('autocomplete:selected', function (event, suggestion, dataset, context) {
        window.location.assign(suggestion.url);
    });

    // Return a formatted date where YYYY-MM-DD
    function formatDate(dateString) {
        let date = new Date(dateString);
        let year = date.getFullYear();
        let month = (date.getMonth() + 1);
        let day = date.getDate();

        if (month < 10) {
            month = '0' + month;
        }

        if (day < 10) {
            day = '0' + day;
        }

        return year + '-' + month + '-' + day;
    }

    // Return the age of the person in question by a given string.
    function getAge(dateString) {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    // Return a formatted employee. Must receive an object representing the employee model.
    function employeeName(employee, last_name_first = true) {
        let first_name;
        let name;

        if (employee.person.preferred_name !== null) {
            first_name  = employee.person.preferred_name;
        }else{
            first_name = employee.person.given_name;
        }

        if (last_name_first) {
           name = employee.person.family_name+', '+first_name;
        }else{
            name = first_name+' '+employee.person.family_name
        }

        return '<a href="/employee/'+employee.uuid+'">'+name+'</a>';
    }

    // Return a formatted student. Must receive an object representing the student model.
    function studentName(student, last_name_first = true) {
        let first_name;
        let name;

        if (student.person.preferred_name !== null) {
            first_name  = student.person.preferred_name;
        }else{
            first_name = student.person.given_name;
        }

        if (last_name_first) {
            name = student.person.family_name+', '+first_name;
        }else{
            name = first_name+' '+student.person.family_name
        }

        return '<a href="/student/'+student.uuid+'">'+name+'</a>';
    }

    // Return a formatted guardian. Must receive an object representing the guardian model.
    function guardianName(guardian, last_name_first = true) {
        let first_name;
        let name;

        if (guardian.person.preferred_name !== null) {
            first_name  = guardian.person.preferred_name;
        }else{
            first_name = guardian.person.given_name;
        }

        if (last_name_first) {
            name = guardian.person.family_name+', '+first_name;
        }else{
            name = first_name+' '+guardian.person.family_name
        }

        return '<a href="/guardian/'+guardian.uuid+'">'+name+'</a>';
    }

    jQuery(document).ready(function () {
        @if(Session::has('color') && Session::has('icon') && Session::has('message') && Session::has('location') )
        Dashmix.helpers('notify', {
            from: '{{ Session::get('location')  }}',
            type: '{{ Session::get('color') }}',
            icon: '{{ Session::get('icon') }}',
            message: '{{ Session::get('message') }}'
        });
        @endif

        $('#header_search_button').click(function() {
             $('#aa-search-input').focus();
        });
    });
</script>
