<div class="main-list clearfix">
<?php
    use App\User;
    use App\Category;
    use App\FeatureCategory;
?>

<div class="top-cont feature clear">

    @foreach($features as $feature)
    <article style="background-image:url({{Storage::url($feature->thumb_path)}})" class="float-left">

            <?php
                $fCateSlug = FeatureCategory::find($feature->cate_id)->slug;
            ?>

            <a href="{{ url('feature/' . $fCateSlug . '/'.$feature->id) }}">

            @if($feature->thumb_path == '')
                <span class="no-img">No Image</span>
            @else
                <div class="main-thumb"></div>
            @endif

            <?php
                $num = Ctm::isAgent('sp') ? 30 : 18;
            ?>

            <div class="meta">
            	<h2>{{ $feature->title }}</h2>
                <p>{{ User::find($feature->model_id)->name }}</p>
            </div>
        </a>
    </article>
    @endforeach
    </div>

	<div class="temporary">

    </div>

    <div class="temporary">

    </div>


    @foreach($atcls as $key => $obj)
    	<div class="top-cont atcl clear">
		<h3>{{ $key }}</h3>

    	@foreach($obj as $atcl)
            <article style="background-image:url({{Storage::url($atcl->thumb_path)}})">

                <?php
                    $cateSlug = Category::find($atcl->cate_id)->slug;
                ?>

                <a href="{{url($cateSlug . '/'.$atcl->id)}}">
                @if($atcl->thumb_path == '')
                    <span class="no-img">No Image</span>
                @else
                    <div class="main-thumb"></div>
                @endif


                <?php
                    $num = Ctm::isAgent('sp') ? 30 : 18;
                ?>

                <div class="meta">
                    <h2>{{ $atcl->title }}</h2>
                    <p>{{ User::find($atcl->model_id)->name }}</p>
                </div>
                </a>
            </article>
    	@endforeach

        </div>
    @endforeach



</div>


{{-- $atcls->links() --}}



