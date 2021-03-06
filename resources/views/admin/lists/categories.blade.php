@extends('adminlte::page')

@section('title', 'AdminLTE')



@section('content')

@include('admin.alerts.success')
@include('admin.alerts.error')


<div class="row">
  <div class="box ">
    <div class="box-header bg-purple-gradient">
      <h3 class="box-title my-2 ">Categories</h3>
       <div class="togglable arrowable">
          <i class="fas fa-plus"></i>
       </div>
      @can('is-editor')
        <div class="card d-none">
          <div class="card-header">
            <h3 class="card-title text-purple">Add New Category</h3>
          </div>
          <div class="card-body">
            <form action="/admin/edit/category/store" method="POST">           
              @csrf
              <div class="form-group">
                <input name="name" value="{{old('name')}}" placeholder="Type Here" type="text" class="form-control">
              </div>
              <button class="btn btn-success" type="submit">Add</button>                
            </form>
          </div>
        </div>
      @endcan

      {{-- <form class="box-tools">
        @csrf
        <div class="input-group input-group-sm p-2" style="">
          <input type="text" name="table_search" class="form-control pull-right mr-2 rounded" placeholder="Search">          
            <button type="submit" class="btn bg-purple"><i class="fa fa-search"></i></button>          
        </div>
      </form> --}}
    </div>
    <!-- /.box-header -->
    
    <div class="box-body table-responsive no-padding">        
      <table class="table table-hover">
        <thead>
          <tr class="bg-gray">
            <th>#</th>                         
            <th>Validated</th>            
            <th>Creation Date</th>
            <th>Name</th>            
            <th>Articles</th>
            <th></th>
          
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as  $key=>$category)                
            <tr class="user-list-item">          
              <td>{{$key+1}}</td>              
              <td>
                @if ($category->valid==true)
                <span class="text-success"><i class="fas fa-check"></i></span>
                @elseif ($category->valid==false)
                  <span class="text-danger"><i class="fas fa-times"></i> </span>
                @elseif ($category->valid==null)
                <span class="text-purple">TBD</span>
                @endif
              </td>
              <td>{{$category->created_at->format('d M Y')}}</td>
              <td>{{$category->name}}</td>                              
              <td><a href="/admin/list/articles/results/{{$category->name}}"><i class="fas fa-search text-purple"></i></a></td>
              <td class="user-list-btn d-flex">
                <a href="/admin/edit/category/{{$category->id}}/edit" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                <form action="/admin/edit/category/{{$category->id}}/delete" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                </form>
              </td>
            </tr>              
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  {{$categories->links()}}
  <!-- /.box -->
</div>

@stop