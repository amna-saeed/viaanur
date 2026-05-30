@php
    use App\Support\CourseCatalog;
    $categoryItems = CourseCatalog::forSlider();
@endphp

<div class="categories-area pt-136 pb-110" id="courses-move">
    <div class="container">
        <div class="categories-section-title text-center" data-cue="slideInUp">
            <div class="section-title d-inline-block">
                <span class="d-inline-block sub-title">Course Category</span>
                <h2>
                    Explore Top
                    <span class="position-relative">Categories</span>
                </h2>
            </div>
        </div>

        <div class="categories-slider">
            <div class="categories-slider-items">
                <div class="categories-slider-info owl-carousel owl-theme">
                    @foreach($categoryItems as $item)
                        <div class="item">
                            <a href="{{ $item['url'] }}" class="single-categories-card text-center d-block text-decoration-none {{ $loop->iteration % 2 === 0 ? 'second-color' : '' }}">
                                <div class="icon mx-auto position-relative z-1">
                                    <img src="{{ asset('assets/images/banner/categories-bg-shape.svg') }}" alt="">
                                    <img class="bg-shape" src="{{ asset('assets/images/banner/' . $item['icon']) }}" alt="{{ $item['title'] }}">
                                </div>
                                <h3>{{ $item['title'] }}</h3>
                                @if(!empty($item['subtitle']))
                                    <p>{{ $item['subtitle'] }}</p>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
