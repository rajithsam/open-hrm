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
        <form class="form-horizontal">
            <div class="col-lg-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>File Columns</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($file_columns))
                            @foreach($file_columns as $file_column)
                                <tr>
                                    <td>
                                        <select class="form-control">
                                            @foreach($file_columns as $file_column)
                                            <option value="{{$file_column}}">{{$file_column}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>                
            </div>
            <div class="col-lg-6">
                <table class="table">
                    <thead>
                        <tr>
                            <td>System Column</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($system_columns))
                            @foreach($file_columns as $file_column)
                            <tr>
                                <td>
                                    <select class="form-control">
                                        @foreach($system_columns as $col)
                                        <option value="{{$col}}">{{$col}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    @endif
</section>
@stop