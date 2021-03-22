<section id="baner-header" class="baner-header">
    <div class="content">
       <h1>Buy or Sell anything on b4mx</h1>
       <ul class="tabs">
         <li class="tab-link current" data-tab="tab-1">Everything</li>
         <li class="tab-link anim-blink" data-tab="tab-2">Try the amazing Filter!</li>

       </ul>
       <div class="tab-content current" id="tab-1">
           <form action="{{ route('ads.add-listing') }}"> <!--  id="search_form" -->
             <input type="text" name="search" id="SearchTagsIndex" placeholder="Search 256 Ads" style="width: 95%;" />
             <button class="bt">Search</button>
           </form>
       </div>
       <div class="tab-content" id="tab-2">
           <form action="{{ route('ads.add-listing') }}">
             <select id="FilterBrand" name="brand" style="width: 100%;">
                  <option value="">All brands</option>
             </select>
             <select id="FilterType" name="type" style="width: 100%;" disabled>
                  <option value="">All types</option>
             </select>
             <select id="FilterModel" name="model" style="width: 100%;" disabled>
                  <option value="">All models</option>
             </select>
             <input type="text" name="search" id="SearchTagsIndex2" placeholder="Search 256 Ads" />
             <button class="bt">Search</button>
           </form>
       </div>
       <p>Not a member of B4MX? <a href="{{url('/getLoginPage?register')}}" class="border-a">Sign Up Now!</a></p>
    </div>
</section>