<div class="main-list clearfix">
<?php
    use App\User;
    use App\Category;
    use App\FeatureCategory;
?>

	<div class="clear">
    @foreach($atcls as $atcl)
    <article class="float-left">

        <?php
        	$cateSlug = Category::find($atcl->cate_id)->slug;
        ?>

        <a href="{{url($cateSlug . '/'.$atcl->id)}}">
        @if($atcl->thumb_path == '')
            <span class="no-img">No Image</span>
        @else
            <div style="background-image:url({{Storage::url($atcl->thumb_path)}})" class="main-thumb"></div>
        @endif
        </a>

        <?php
        	$num = Ctm::isAgent('sp') ? 30 : 18;
        ?>
        <h2><a href="{{ url($cateSlug . '/'.$atcl->id) }}">{{ Ctm::shortStr($atcl->title, $num) }}</a></h2>
        <div class="meta">
            <p>モデル：{{ User::find($atcl->model_id)->name }}</p>
            <p>公開日：{{ Ctm::changeDate($atcl->open_date)}}</p>
        </div>
    </article>
    @endforeach

    </div>

	<div class="clear">
    @foreach($features as $feature)
    <article class="float-left">

        <?php
        	$fCateSlug = FeatureCategory::find($feature->cate_id)->slug;
        ?>

        <a href="{{ url('feature/' . $fCateSlug . '/'. $feature->id) }}">
        @if($feature->thumb_path == '')
            <span class="no-img">No Image</span>
        @else
            <div style="background-image:url({{Storage::url($feature->thumb_path)}})" class="main-thumb"></div>
        @endif
        </a>

        <?php
        	$num = Ctm::isAgent('sp') ? 30 : 18;
        ?>
        <h2><a href="{{ url('feature/' . $fCateSlug . '/'.$feature->id) }}">{{ Ctm::shortStr($feature->title, $num) }}</a></h2>
        <div class="meta">
            <p>モデル：{{ User::find($feature->model_id)->name }}</p>
            <p>公開日：{{ Ctm::changeDate($feature->created_at)}}</p>
        </div>
    </article>
    @endforeach
    </div>


</div>


{{ $atcls->links() }}



