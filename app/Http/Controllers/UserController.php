<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UserRequest;
use Storage;
use ImgInt;
use Hash;
use Route;

class UserController extends Controller
{
    public function index() {

      $users = User::with('role')->where('roles_id', '!=','1')->get();
      return view('admin/users/index', compact('users'));

    }


    public function create() {

      return view('admin/users/create');

    }

    public function store(UserRequest $request){
      $this->validate($request, [
        'name' => 'bail|required|max:32|unique:users', 
        'email' => 'bail|required|email|max:75|unique:users'
      ]);
      $user= new User;
      $users= User::all();
      $user->name = $request->name;      
      $user->email = $request->email;                
      $user->password = bcrypt($request->password);
      $user->roles_id = $request->role;
      if ($request->bio) {
        $user->bio = $request->bio;
      }
      if ($request->file('image')) {
        $image = $request->file('image');
        $imagename = time().$image->hashname();
        $image->storeAs('public/images/users/originals/', $imagename);
        $resized = ImgInt::make($image)->resize(350,436)->save();
        Storage::put('public/images/users/mediums/'.$imagename, $resized);
        $thumbnail = ImgInt::make($image)->resize(100,100)->save();
        Storage::put('public/images/users/thumbnails/'.$imagename, $thumbnail);
        $user->image = $imagename;
      }
      $user->save();
      $request->session()->flash('success', 'User Successfully Created !');
      return redirect()->back();
    }

    public function edit($id) {
      $user = User::find($id);
      return view('admin.lists.cards.edituser', compact('user'));
    }

    public function update(UserRequest $request, $id){
      $user = User::find($id);
      if($request->name!=$user->name){
        $this->validate($request,[
          'name' => 'bail|required|max:32|unique:users',           
          ]);
          $user->name = $request->name;
        }
        if($request->email!=$user->email){
          $this->validate($request,[            
            'email' => 'bail|required|email|max:75|unique:users'
            ]);
            $user->email = $request->email;
          }
      $user->title = $request->title;            
      if (($request->password != $user->password) && (!(Hash::check($request->password,$user->password)))) {        
        $user->password = bcrypt($request->password);
      }
      if ($request->role){
        $user->roles_id = $request->role;
      }
      if ($request->file('image')) {
        $image = $request->file('image');
        $imagename = time().$image->hashname();
        Storage::delete(['public/images/users/thumbnails/'.$user->image,'public/images/users/originals/'.$user->image,'public/images/users/mediums/'.$user->image,]);
        $image->storeAs('public/images/users/originals/', $imagename);
        $resized = ImgInt::make($image)->resize(350,436)->save();
        Storage::put('public/images/users/mediums/'.$imagename, $resized);
        $thumbnail = ImgInt::make($image)->resize(100,100)->save();
        Storage::put('public/images/users/thumbnails/'.$imagename, $thumbnail);
        $user->image = $imagename; 
      }
      if ($request->bio) {
        $user->bio = $request->bio;
      }
      $user->save();
      $request->session()->flash('success', 'User Successfully Updated !');
      return redirect('admin/list/users');
      
    }

    public function delete(Request $request, $id) {
      $user = User::find($id);
      $articles = $user->articles;
      $comments = $user->comments;      
      if ($id!=\Auth::id()) {
        Storage::delete(['public/images/users/thumbnails/'.$user->image,'public/images/users/originals/'.$user->image,'public/images/users/mediums/'.$user->image,]);        
        if ($articles->isNotEmpty()) {          
          $articles->delete();
        }
        if ($comments->isNotEmpty()) {
          $comments->delete();
        }
        $user->delete();
        $request->session()->flash('success', 'User Successfully Deleted !');
        return redirect()->back();
      } else {
          $request->session()->flash('error', "You Can't Delete Your Own Account");
          return redirect()->back();
        }
    }
}
