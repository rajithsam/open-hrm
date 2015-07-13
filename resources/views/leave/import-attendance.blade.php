@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    
    @if(empty($file_name))
    <div class="panel panel-default">
        
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{url('attendance/save-import-attendance')}}" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <div class="form-group">
                    <label class="control-label col-lg-3">Browse</label>
                    <div class="col-lg-3">
                        <input type="file" name="attendance"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Import"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="panel panel-default">
        
    </div>
    @endif
</section>
@stop