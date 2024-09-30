<div class="accordion custom-filter" id="filterAccordion">
    <div class="accordion-item custom-accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="{{ $filterIsEmpty ? 'false' : 'true' }}"
                    aria-controls="collapseOne">
                Filter Products
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse {{ $filterIsEmpty ? '' : 'show' }}"
             aria-labelledby="headingOne" data-bs-parent="#filterAccordion">
            <div class="accordion-body">
                <form id="filter-form" action="{{ url()->current() }}" method="GET">
                    <div class="row">
                        <div class="col-md-2 col-sm-6">
                            <label for="category">Category</label>
                            <select id="category-select" name="category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach ($productCategories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label for="size">Size</label>
                            <select id="sizes-select" disabled  name="size" class="form-control">
                                <option value="">All Sizes</option>
                                <!-- This will be populated dynamically by JavaScript -->
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label for="price-range" class="d-block">Price Range</label>
                                <div class="price-range-container">
                                    <input type="text" id="min-price" name="min_price"
                                           class="form-control min-price" placeholder="Min Price"
                                           value="{{$minPrice}}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    <div class="divider"></div>
                                    <input type="text" id="max-price" name="max_price"
                                           class="form-control max-price" placeholder="Max Price"
                                           value="{{$maxPrice}}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label for="city">City</label>
                            <select id="city-select" name="city" class="form-control">
                                <option value="">All cities</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label for="sort">Sort By</label>
                            <select id="sort-select" name="sort" class="form-control">
                                <option value="">Default</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                    Price: Low to High
                                </option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Price: High to Low
                                </option>
                                <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>
                                    Date: Oldest First
                                </option>
                                <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>
                                    Date: Newest First
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4 mt-4">
                            <button type="submit" class="btn btn-primary apply-button">Apply</button>
                            <button type="button" id="reset-filters" class="btn btn-secondary ms-2 reset-button">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
