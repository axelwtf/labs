<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Text;
use App\Service;
use App\Testimonial;
use App\Project;
use App\User;
use App\Article;
use App\Category;
use App\Tag;
use App\Comment;
use App\Icon;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminpageController extends Controller
{

  public function index()
  {
      return view('admin/adminhome');
  }
  
    public function home(){
      $text= Text::find(1);
      $carouselImages = Image::where('folder','carousel')->get();
      $YTimage = Image::where('folder','youtube')->get()->first();
      $servicesup = Service::with('icons')->get()->random(2);
      $servicedown = Service::with('icons')->get()->random(1);
      $services = Service::paginate(9);
      $testimonials = Testimonial::with('clients')->get()->random(6);
      $teammembers = User::where('roles_id','2')->get()->random(2);
      $teamleader = User::where('roles_id', '1')->get()->first();
      $icons = Icon::all();

      return view ('admin/pages/home', compact('carouselImages','YTimage','text','services','servicesup','servicedown','testimonials','teammembers','teamleader','icons'));

    }


    public function services(){
      $text= Text::find(1);
      $services = Service::paginate(9);
      $servicesleft = Service::with('icons')->get()->random(3);
      $servicesright = Service::with('icons')->get()->random(3);
      $projects= Project::orderBy('created_at')->get()->take(3);
      $icons = Icon::all();
      $phoneimage= Image::where('folder','services')->get()->first();
      return view ('admin/pages/services', compact('text','services','servicesleft','servicesright','projects','icons','phoneimage'));
    }

    public function blog(){
      $text = Text::find(1);
      $articles = Article::with('users','comments','tags','categories')->paginate(3);
      $categories = Category::all();
      $instagrams= Image::where('folder','instagram')->get();
      $tags = Tag::all();
      $ad= Image::where('folder','ad')->first();
      $quote = Testimonial::get()->random(1)->first();
      // Article::orderBy('created_at');
      return view ('admin/pages/blog', compact('text','articles','categories','instagrams','tags','ad','quote'));
    }


    public function blogpost($id){
      $text = Text::find(1);
      $article= Article::with('users', 'comments', 'tags')->find($id);
      $categories = Category::all();
      $instagrams= Image::where('folder','instagram')->get();
      $tags = Tag::all();
      $ad= Image::where('folder','ad')->first();
      $quote = Testimonial::get()->random(1)->first();
      
      // $comments = Comment::where('articles_id', $id)/* ->where('valid', 1) */->get();
      $comments = Comment::with('users')->where('articles_id',$id)->get();
      // Article::orderBy('created_at');
      return view ('admin/pages/blogpost', compact('text','article','categories','instagrams','tags','ad','quote','comments'));
    }
    
    public function search(Request $request){
      $search = $request->search;
      return redirect('/admin/results/'.$search);
    }
    public  function results($search,Request $request){
      $allarticles = Article::with('users','comments','tags')->get();
      // $search = $request->search;
      $tagmatch = Tag::where('name',$search)->first();
      $categorymatch = Category::where('name',$search)->first();
      $results= collect([]);
      // dd($tagmatch);
      
      foreach ($allarticles as $article) {
        // NAME Search
        if (preg_match('/\b'.$search.'\b/i', $article->name)) {
          if(!$results->contains($article)){
            $results->push($article);       
          }      
        }
        // TAGS Search
        if($tagmatch){
          foreach ($article->tags as $tag) {
            if ($tag->name==$tagmatch->name) {
              if(!$results->contains($article)){
                $results->push($article);                
              }
            }
          }
        }
        // CATEGORY Search
        if($categorymatch){
          foreach ($article->categories as $category) {
            if($category->name=$categorymatch->name) {
              if(!$results->contains($article)) {
                $results->push($article);          
              }
            }
          }
        }
      }
      // Collection Pagination Fix
       $currentPage = LengthAwarePaginator::resolveCurrentPage();
       $perPage = 3;
       $currentPageItems = $results->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
       $paginatedItems= new LengthAwarePaginator($currentPageItems , count($results), $perPage);
       $paginatedItems->setPath($request->url());
      $text = Text::find(1);
      $categories = Category::all();
      $instagrams= Image::where('folder','instagram')->get();
      $tags = Tag::all();
      $ad= Image::where('folder','ad')->first();
      $quote = Testimonial::get()->random(1)->first();
      // Article::orderBy('created_at');
      return view ('admin/pages/blogsearch',['results' => $paginatedItems], compact('text','articles','categories','instagrams','tags','ad','quote','tagmatch'));
    }

    public function contact(){
      $text = Text::find(1); 
      return view ('admin/pages/contact', compact('text'));
    }
}
