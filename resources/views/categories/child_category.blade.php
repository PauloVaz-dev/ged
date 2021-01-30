<li>{{ $childCategory->name }}</li>
@if ($childCategory->categories)
    <ul>
        @foreach ($childCategory->categories as $childCategory)
            @include('categories.child_category', ['categories.child_category' => $childCategory])
        @endforeach
    </ul>
@endif