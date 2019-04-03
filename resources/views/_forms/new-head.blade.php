{{--
OPTIONAL
$color = The color of the panel border
--}}

<!-- Begin: Admin Form -->
@if(count($errors))
   <br />
   <div class="form-group">
       <div class="alert alert-important alert-danger" role="alertdialog">
           <ul>
               @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   </div>
@endif

