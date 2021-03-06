@can ('is-admin')
<div class="card d-none">
  <div class="card-header bg-purple-gradient">
    <h3 class="card-title">Edit Text</h3>
  </div>
  <div class="card-body">
    <form action="/admin/edit/homepage/standouttext" method="POST">
      @csrf
      <div class="form-group">
        <input name="text" value="{{old('title', $text->standouttext)}}" placeholder="Type here" type="text" class="form-control">
      </div>
      <button class="btn btn-success" type="submit">OK</button>
    </form>
  </div>
</div>
@endcan