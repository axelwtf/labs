@if(session('status'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4>
    <i class="icon fa fa-check"></i> 
    {{session('success')}}
  </h4>
  {{session('message')}}
</div>
@endif