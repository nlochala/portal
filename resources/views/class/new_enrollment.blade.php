@extends('layouts.backend')

@section('content')
    @include('class._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{!! $class->fullName(true)!!} - New Enrollment</h1>

    <!--
    panel.row
    panel.column
    panel.panel
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->
    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 3])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Filter Options', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <ul>
        <li>{!! link_to('/class/'.$class->uuid.'/edit_enrollment/gradeLevels', 'Grade Levels') !!}</li>
        <li>{!! link_to('/class/'.$class->uuid.'/edit_enrollment/homeroom', 'Homerooms') !!}</li>
    </ul>

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 9])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Class Enrollment', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::model($class,['method' => 'PATCH','files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    @include('class._new_enrollment')
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')


    @include('layouts._content_end')
@endsection


@section('js_after')
    <script type="text/javascript">;
        jQuery(document).ready(function () {

            $('#student-list').multiSelect({
                selectableOptgroup: true,
                selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search...'>",
                selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search...'>",
                afterInit: function(ms){
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e){
                            if (e.which === 40){
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e){
                            if (e.which == 40){
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });

        });
    </script>
@endsection
