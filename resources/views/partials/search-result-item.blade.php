@if(isset($product))
    <a class="search-link" style="text-decoration: none" href="{{ url('/products/' . $product->id) }}">
        <li class="list-group-item custom-list-group-item">
            {{ $product->name }} - {{ $product->price }}MDL
        </li>
    </a>
@elseif(isset($shop))
    <a style="text-decoration: none" href="{{ url('/shops/' . $shop->id) }}">
        <li class="list-group-item custom-list-group-item">
            {{ $shop->name }}
        </li>
    </a>
@endif
