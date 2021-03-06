@extends('adminlte::page')

@section('title', 'AdminLTE')



@section('content')

@include('admin.alerts.success')
@include('admin.alerts.error')


@if ($user->roles_id!=1 || Gate::check('is-admin'))
<div class="row">
  <div class="box ">
    <div class="box-header bg-purple-gradient">
      <h3 class="box-title my-2 ">{{$user->name}}'s Comments</h3>      
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover">
        <thead>
          <tr class="bg-gray">
            <th>#</th>                         
            <th>Validated</th>            
            <th>Creation Date</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Article</th>
            <th></th>
          
          </tr>
        </thead>
        <tbody>
          @foreach ($user->comments as  $key=>$comment)                
            <tr class="user-list-item">          
              <td>{{$key+1}}</td>               
              <td>
                @if ($comment->valid==true)
                  <span class="text-success"><i class="fas fa-check"></i></span>
                @elseif ($comment->valid==false)
                  <span class="text-danger"><i class="fas fa-times"></i></span>
                @elseif ($comment->valid==null)
                  <span class=""><i class="fas fa-bell"></i></span>
                @endif
              </td>
              <td>{{$comment->created_at->format('d M Y')}}</td>
              <td>{{substr($comment->subject,0,30)}}...</td>
              <td>{{substr($comment->message,0,30)}}...</td>                
              <td>
                @if ($comment->articles)
                  @if (Auth::user()->id==1)
                  <a href="/admin/edit/blogpost/{{$comment->articles->id}}"><i class="fas fa-search text-purple"></i></a>
                  @else
                  <a href="/blogpost/{{$comment->articles->id}}"><i class="fas fa-search text-purple"></i></a>
                  @endif
                @else
                  <span class="text-gray">Deleted</span>
                @endif

              </td>
              <td class="user-list-btn d-flex">
                @can('is-admin')
                <form action="/admin/edit/comment/{{$comment->id}}/confirm" method="post">
                  @csrf
                  <button class="btn btn-success"><i class="fas fa-check"></i></button>
                </form>
                @endcan
                <a href="/admin/edit/comment/{{$comment->id}}/edit" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                <form action="/admin/edit/comment/{{$comment->id}}/delete" method="POST">
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
  <!-- /.box -->
</div>
@endif
@stop