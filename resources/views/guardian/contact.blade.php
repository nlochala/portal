@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->

    @include('guardian._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $guardian->person->fullName() }}'s Contact
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
    @can('guardians.update.contact')
        <hr/>
        <button type="button" dusk="btn-modal-block-email" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
                data-target="#modal-block-email">
            <i class="fa fa-fw fa-pen mr-1"></i> Update Email Addresses
        </button>
    @endcan
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
                    @can('guardians.update.contact')
                        <div class="btn-group">
                            <button type="button" dusk="btn-delete-phone-{{ $phone->uuid }}"
                                    class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete"
                                    onclick="window.location.href='/phone/{{ $phone->uuid }}/profile/delete'">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    @endcan
                </td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif
    @can('guardians.update.contact')
        <hr/>
        <button type="button" dusk="btn-modal-block-phone" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
                data-target="#modal-block-phone">
            <i class="fa fa-fw fa-plus mr-1"></i> Add New Phone Number
        </button>
    @endcan

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
                    @can('guardians.update.contact')
                        <div class="btn-group">
                            <button type="button" dusk="btn-modal-block-address-{{ $address->id }}"
                                    class="btn btn-sm btn-outline-primary" data-toggle="modal" title="Edit"
                                    data-target="#modal-block-address-{{ $address->id }}">
                                <i class="fa fa-pen"></i>
                            </button>
                            <button type="button" dusk="btn-delete-address-{{ $address->uuid }}"
                                    class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete"
                                    onclick="window.location.href='/address/{{ $address->uuid }}/delete'">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    @endcan
                </td>

                @endforeach
                @include('_tables.end-new-table')
                @endif
                @can('guardians.update.contact')
                    <hr/>
                    <button type="button" dusk="btn-modal-block-address-new" class="btn btn-outline-success mr-1 mb-3"
                            data-toggle="modal"
                            data-target="#modal-block-address-new">
                        <i class="fa fa-fw fa-plus mr-1"></i> Add New Address
                    </button>
                @endcan
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

            <!-- START FORM----------------------------------------------------------------------------->
                {!! Form::model($person,['method' => 'PATCH','id' => 'email-form','url' => '/guardian/' . $guardian->uuid . '/profile/store_email']) !!}
                @include('person._create_form_email')
                @include('layouts._forms._form_close')
            <!-- END FORM----------------------------------------------------------------------------->
                @include('layouts._modal_panel_end')
            <!-------------------------------- Modal: Update Email Addresses END------------------------------------------->
                <!-------------------------------- Modal: New Phone Start------------------------------------------->
                @include('layouts._modal_panel_start',[
                    'id' => 'modal-block-phone',
                    'title' => 'Add New Phone Number'
                ])
            <!-- START FORM----------------------------------------------------------------------------->

                {!! Form::open(['files' => false, 'id' => 'phone-form','url' => '/guardian/' . $guardian->uuid . '/profile/store_phone']) !!}
                @include('person._create_form_phone')
                @include('layouts._forms._form_close')
            <!-- END FORM----------------------------------------------------------------------------->
                @include('layouts._modal_panel_end')
            <!-------------------------------- Modal: END------------------------------------------->
                <!-------------------------------- Modal: New Address Start------------------------------------------->
                @include('layouts._modal_panel_start',[
                    'id' => 'modal-block-address-new',
                    'title' => 'Add New Address'
                ])
                {!! Form::open(['files' => false, 'id' => 'address-form','url' => '/guardian/' . $guardian->uuid . '/profile/store_address']) !!}
                @include('person._create_form_address')
                @include('layouts._forms._form_close')
            <!-- END FORM----------------------------------------------------------------------------->
                @include('layouts._modal_panel_end')
            <!-------------------------------- Modal: END------------------------------------------->
                @foreach($addresses as $address)
                <!-------------------------------- Modal: Update Address Start------------------------------------------->
                    @include('layouts._modal_panel_start',[
                        'id' => 'modal-block-address-' . $address->id,
                        'title' => 'Update Address'
                    ])
                    {!! Form::model($address,['method' => 'PATCH','id' => 'address-update-form','url' => "/guardian/$guardian->uuid/address/$address->uuid/update_address"]) !!}
                    @include('person._create_form_address',['edit_address' => $address])
                    @include('layouts._forms._form_close')
                <!-- END FORM----------------------------------------------------------------------------->
                    @include('layouts._modal_panel_end')
                <!-------------------------------- Modal: Update Address END------------------------------------------->
                @endforeach
                @endsection


                @section('js_after')
                    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianEmailRequest','#email-form') !!}
                    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianPhoneRequest','#phone-form') !!}
                    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianAddressRequest','#address-form') !!}
                    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianAddressRequest','#address-update-form') !!}

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
                        });
                    </script>
@endsection
