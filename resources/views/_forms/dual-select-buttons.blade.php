<!--  REQUIRED $id -->


@include('_forms.end-new-column')
@include('_forms.new-column',['column_size' => 'col-md-2'])
<br />
<br />
<br />
<button type="button" id="multiselect{{ $id }}_rightAll"      class="btn btn-xs btn-block btn-primary"><i class="glyphicon glyphicon-forward"></i></button>
<button type="button" id="multiselect{{ $id }}_rightSelected" class="btn btn-xs btn-block btn-info"><i class="glyphicon glyphicon-chevron-right"></i></button>
<button type="button" id="multiselect{{ $id }}_leftSelected"  class="btn btn-xs btn-block btn-info"><i class="glyphicon glyphicon-chevron-left"></i></button>
<button type="button" id="multiselect{{ $id }}_leftAll"       class="btn btn-xs btn-block btn-primary"><i class="glyphicon glyphicon-backward"></i></button>
@include('_forms.end-new-column')
@include('_forms.new-column',['column_size' => 'col-md-5'])
