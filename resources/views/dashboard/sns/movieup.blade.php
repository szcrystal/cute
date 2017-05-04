@extends('layouts.appDashBoard')

@section('content')

	<div class="clearfix">
    	<h3 class="page-header">管理者一覧</h3>
    </div>

    {{-- $obj->links() --}}

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="col-md-2">日付</th>
              <th class="col-md-1">記事ID</th>
              <th class="col-md-6">タイトル</th>
              <th class="col-md-3">View数</th>
            </tr>
          </thead>
          <tbody>

          {!! $htmlBody !!}

          <?php print_r($_SESSION); ?>

        {{--
            @foreach($obj as $key => $val)
                <tr>
                    <td>
                    	{{ $val['view_date'] }}
                    </td>

                    <td>
                        {{ $val['atcl_id'] }}
                    </td>
                    <td>
                        {{ $atcl->find($val['atcl_id'])->title }}
                    </td>

                    <td>
                        {{ $val['view_count'] }}
                    </td>
                </tr>
            @endforeach
		--}}
        </tbody>
    </table>

    </div>

    {{-- $obj->links() --}}

        
@endsection

