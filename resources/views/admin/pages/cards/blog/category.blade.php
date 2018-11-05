@can ('is-admin')
<div class="card d-none">
  <div class="card-header">
    <h3 class="card-title">Edit Category</h3>
  </div>
  <div class="card-body">
    <form action="/admin/edit/category/{{$category->id}}" method="POST">
      @csrf
      <div class="form-group">
        <input name="name" value="{{old('name', $category->name)}}" placeholder="Type here" type="text" class="form-control">
      </div>
      <button class="btn btn-success" type="submit">OK</button>
    </form>
    <form action="/admin/edit/category/{{$category->id}}/delete" method="post">
      @csrf
      <button class="btn btn-danger" type="submit">Delete</button>
    </form>
  </div>
</div>
@endcan