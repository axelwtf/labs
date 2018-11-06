		<!-- Sidebar area -->
    <div class="col-md-4 col-sm-5 sidebar">
        <!-- Single widget -->
        <div class="widget-item">
          <form action="/search" class="search-form" method="POST">
            @csrf
            <input name="search" type="text" placeholder="Search">
            <button class="search-btn" type="submit"><i class="flaticon-026-search"></i></button>
          </form>
        </div>
        <!-- Categories -->
        <div class="widget-item">
          <h2 class="widget-title">{!!$text->categories!!}</h2>
          <ul>
            @foreach ($categories as $category)
            <li><a href="#">{{$category->name}}</a></li>
            @endforeach
          </ul>
        </div>
        <!-- Instagram-->
        <div class="widget-item">
          <h2 class="widget-title">{!!$text->instagram!!}</h2>
          <ul class="instagram">
            @foreach ($instagrams as $instagram)
              <li><img src="{{Storage::url('public/images/instagram/thumbnails/'.$instagram->name)}}" alt=""></li>
            @endforeach
          </ul>
        </div>
        <!-- Tags -->
        <div class="widget-item">
          <h2 class="widget-title">{!!$text->tags!!}</h2>
          <ul class="tag">
            @foreach ($tags as $tag)
              <li><a href="">{{$tag->name}}</a></li>
            @endforeach
          </ul>
        </div>
        <!-- Quote-->
        <div class="widget-item">
          <h2 class="widget-title">{!!$text->quote!!}</h2>
          <div class="quote">
            <span class="quotation">‘​‌‘​‌</span>
            <p>{{$quote->message}}</p>
          </div>
        </div>
        <!-- Ad -->
        <div class="widget-item">
          <h2 class="widget-title">{!!$text->ad!!}</h2>
          <div class="add">
            <a href=""><img src="{{Storage::url('public/images/ad/'.$ad->name)}}" alt=""></a>
          </div>
        </div>
      </div>