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


class PagesController extends Controller
{

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
      return view ('home', compact('carouselImages','YTimage','text','services','servicesup','servicedown','testimonials','teammembers','teamleader'));
    }

    public function services(){
      $text= Text::find(1);
      $services = Service::paginate(9);
      $servicesleft = Service::with('icons')->get()->random(3);
      $servicesright = Service::with('icons')->get()->random(3);
      $projects= Project::orderBy('created_at')->get()->take(3);
      $phoneimage= Image::where('folder','services')->get()->first();
      return view ('services', compact('text','services','servicesleft','servicesright','projects','phoneimage'));
    }

    public function blog(){
      $text = Text::find(1);
      $articles = Article::with('users','comments','tags')->paginate(3);
      $categories = Category::all();
      $instagrams= Image::where('folder','instagram')->get();
      $tags = Tag::all();
      $ad= Image::where('folder','ad')->first();
      $quote = Testimonial::get()->random(1)->first();
      // Article::orderBy('created_at');
      return view ('blog', compact('text','articles','categories','instagrams','tags','ad','quote'));
    }

    public  function search(Request $request){
      $allarticles = Article::with('users','comments','tags')->get();
      $tagmatch = Tag::where('name',$request->search)->first();
      $results= collect([]);
      
      foreach ($allarticles as $article) {
        // dd($article->name);

        // if ($article->name->($tagmatch->name) {        
            // $results->push($article);          
        // }


        // foreach ($article->tags as $tag) {
        //   if ($tag->name==$tagmatch->name) {
        //     if(!$result->contains($article)){
        //       $results->push($article);
        //     }
        //   }
        // }
      }

      dd($results);
      // dd($articles);
      $text = Text::find(1);
      $categories = Category::all();
      $instagrams= Image::where('folder','instagram')->get();
      $tags = Tag::all();
      $ad= Image::where('folder','ad')->first();
      $quote = Testimonial::get()->random(1)->first();
      // Article::orderBy('created_at');
      return view ('blogsearch', compact('text','articles','categories','instagrams','tags','ad','quote','tagmatch'));
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
      return view ('blogpost', compact('text','article','categories','instagrams','tags','ad','quote','comments'));
    }
    
    public function contact(){
      $text = Text::find(1); 
      return view ('contact', compact('text'));
    }
}
