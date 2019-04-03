@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->

    @include('person._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ auth()->user()->person->preferredName() }}'s Contact
        Information</h1>

    @include('layouts._content_start')
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
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Email Addresses'])
    @include('layouts._panels_start_content')
    <!-- TABLE OF EMAIL ADDRESSES -->
    @include('_tables.new-table',['id' => 'email-table', 'table_head' => ['Email Type','Address']])
    <tr>
        <td>Email - Primary</td>
        <td>
            @if($person->email_primary)
                <a href="mailto:{{ $person->email_primary }}">{{ $person->email_primary }}</a>
            @else
                <em>
                    <small>N/A</small>
                </em>
            @endif
        </td>
    </tr>
    <tr>
        <td>Email - Secondary</td>
        <td>
            @if($person->email_secondary)
                <a href="mailto:{{ $person->email_secondary}}">{{ $person->email_secondary}}</a>
            @else
                <em>
                    <small>N/A</small>
                </em>
            @endif
        </td>
    </tr>
    <tr>
        <td>School Email</td>
        <td>
            @if($person->email_school)
                <a href="mailto:{{ $person->email_school}}">{{ $person->email_school}}</a>
            @else
                <em>
                    <small>N/A</small>
                </em>
            @endif
        </td>

    </tr>
    @include('_tables.end-new-table')
    <hr/>
    <button type="button" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-email">
        <i class="fa fa-fw fa-pen mr-1"></i> Update Email Addresses
    </button>
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Phone Numbers'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF PHONE NUMBERS -->
    @if($phone_numbers->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'phone_table', 'table_head' => [
        'Phone Type',
        'Country',
        'Number',
        'Actions'
        ]])
        @foreach($phone_numbers as $phone)
            <tr>
                <td>{{ $phone->phoneType->name }}</td>
                <td>{{ $phone->country->name }}</td>
                <td>(+{{ $phone->country->country_code }}) {{ $phone->number }}
                    @if($phone->extension)
                        Ext. {{ $phone->extension }}
                    @endif
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete"
                                onclick="window.location.href='/phone/{{ $phone->id }}/profile/delete'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif
    <hr/>
    <button type="button" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-phone">
        <i class="fa fa-fw fa-plus mr-1"></i> Add New Phone Number
    </button>

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>

    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    @include('layouts._panels_start_panel', ['title' => 'Addresses'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    @if($addresses->isEmpty())
        <small><em>There are currently no addresses on record for this individual.</em></small>
    @else
        @include('_tables.new-table',['id' => 'address-table', 'table_head' => ['Address Type','Mailing Label','Actions']])
        @foreach($addresses as $address)
            <tr>
                <td><h5>{{ $address->addressType->name }}</h5></td>
                <td><a href="javascript:void(0)" data-html="true" data-toggle="popover" data-animation="true"
                       data-placement="top" title="Description" data-content="
                   <strong>Street Address 1: {{ $address->address_line_1 }}<br />
                   @if($address->address_line_2)
                            Street Address 2: {{ $address->address_line_2 }}<br />
                   @endif
                            City: {{ $address->city }}<br />
                   Province/State: {{ $address->province }}<br />
                   Country: {{ $address->country->name }}<br />
                   Postal Code: {{ $address->postal_code }}<br /> ">
                        {{ $address->address_line_1 }} <br/>
                        @if($address->address_line_2)
                            {{ $address->address_line_2 }} <br/>
                        @endif
                        {{ $address->city }}, {{ $address->province }} <br/>
                        {{ $address->country->name }} <br/>
                        Postal Code: {{ $address->postal_code }}
                    </a>
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" title="Edit"
                                data-target="#modal-block-address-{{ $address->id }}">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete"
                                onclick="window.location.href='/address/{{ $address->id }}/profile/delete'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>

                @endforeach
                @include('_tables.end-new-table')
                @endif
                <hr/>
                <button type="button" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
                        data-target="#modal-block-address-new">
                    <i class="fa fa-fw fa-plus mr-1"></i> Add New Address
                </button>

                @include('layouts._panels_end_content')
                @include('layouts._panels_end_panel')
            <!-------------------------------------------------------------------------------->
                <!-------------------------------------------------------------------------------->
                @include('layouts._panels_end_column')
                @include('layouts._panels_end_row')

                @include('layouts._content_end')




            <!-------------------------------- Modal: Update Email Addresses Start------------------------------------------->
                @include('layouts._modal_panel_start',[
                    'id' => 'modal-block-email',
                    'title' => 'Update Email Addresses'
                ])
                @include('person._create_form_email')
                @include('layouts._modal_panel_end')
            <!-------------------------------- Modal: Update Email Addresses END------------------------------------------->
                <!-------------------------------- Modal: New Phone Start------------------------------------------->
                @include('layouts._modal_panel_start',[
                    'id' => 'modal-block-phone',
                    'title' => 'Add New Phone Number'
                ])
                @include('person._create_form_phone')
                @include('layouts._modal_panel_end')
            <!-------------------------------- Modal: END------------------------------------------->
                <!-------------------------------- Modal: New Address Start------------------------------------------->
                @include('layouts._modal_panel_start',[
                    'id' => 'modal-block-address-new',
                    'title' => 'Add New Address'
                ])
                @include('person._create_form_address')
                @include('layouts._modal_panel_end')
            <!-------------------------------- Modal: END------------------------------------------->
                @foreach($addresses as $address)
                <!-------------------------------- Modal: Update Address Start------------------------------------------->
                    @include('layouts._modal_panel_start',[
                        'id' => 'modal-block-address-' . $address->id,
                        'title' => 'Update Address'
                    ])
                    @include('person._create_form_address',['edit_address' => $address])
                    @include('layouts._modal_panel_end')
                <!-------------------------------- Modal: Update Address END------------------------------------------->
                @endforeach
                @endsection


                @section('js_after')
                    <script type="text/javascript">
                        jQuery(document).ready(function () {

                            @foreach($addresses as $address)
                            $("#country_id_{{ $address->id }}").select2({placeholder: "Choose One..."});
                            $("#address_type_id_{{ $address->id }}").select2({placeholder: "Choose One..."});
                            @endforeach

                            $("#phone_type_id").select2({placeholder: "Choose One..."});
                            $("#country_id").select2({placeholder: "Choose One..."});
                            $("#address_type_id").select2({placeholder: "Choose One..."});
                            $("#country_id_phone").select2({placeholder: "Choose One..."});

                            @include('layouts._forms._js_validate_start')
                            // Init Form Validation
                            jQuery('#email-form').validate({
                                ignore: [],
                                rules: {
                                    'email_primary': {
                                        required: true,
                                        email: true
                                    },
                                    'email_secondary': {
                                        email: true
                                    },
                                    'email_school': {
                                        email: true
                                    }
                                },
                                messages: {}
                            });

                            // Init Form Validation
                            jQuery('#phone-form').validate({
                                ignore: [],
                                rules: {
                                    'country_id_1': {
                                        required: true
                                    },
                                    'phone_type_id': {
                                        required: true
                                    },
                                    'number': {
                                        required: true,
                                        number: true
                                    },
                                    'extension': {
                                        required: false,
                                        number: true
                                    }
                                },
                                messages: {}
                            });

                            jQuery('#address-form').validate({
                                ignore: [],
                                rules: {
                                    'country_id': {
                                        required: true
                                    },
                                    'province': {
                                        required: true
                                    },
                                    'city': {
                                        required: true
                                    },
                                    'address_type_id': {
                                        required: true
                                    },
                                    'address_line_1': {
                                        required: true
                                    },
                                    'postal_code': {
                                        required: false,
                                        number: true
                                    }
                                },
                                messages: {}
                            });
                            @include('layouts._forms._js_validate_end')
                        });
                    </script>
@endsection