@foreach($category as $categories)
    @foreach($ads as $ad)
        @if($categories->id == $ad->subCategoryId)
        <h1>{{ $ad['adsBike'] }}</h1>
        @endif
    @endforeach
@endforeach
