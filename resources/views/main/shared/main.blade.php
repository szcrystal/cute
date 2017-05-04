<div class="main-list clearfix">
<?php
    use App\Admin;
?>
    @foreach($atcls as $atcl)
    <article class="float-left">

        <a href="{{url('m/'.$atcl->id)}}">
        @if($atcl->thumbnail == '')
            <span class="no-img">No Image</span>
        @else
            <div style="background-image:url({{Storage::url($atcl->thumbnail)}})" class="main-thumb"></div>
        @endif
        </a>

        <?php
        	$num = Ctm::isAgent('sp') ? 30 : 18;
        ?>
        <h2><a href="{{url('m/'.$atcl->id)}}">{{ Ctm::shortStr($atcl->title, $num) }}</a></h2>
        <div class="meta">
            <p>オーナー：{{ Admin::find($atcl->admin_id)->name }}</p>
            <p>公開日：{{ Ctm::changeDate($atcl->open_date)}}</p>
        </div>
    </article>
    @endforeach
</div>


{{ $atcls->links() }}



