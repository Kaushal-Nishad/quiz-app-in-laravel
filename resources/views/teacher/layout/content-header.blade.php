<div class="page-title">
    <div class="title_left">
        <h3>{{$title}} <span> {{$add_btn}}</span></h3>
    </div>
    <ol class="title_right">
        <ol class="pull-right breadcrumb m-0">
            @foreach($breadcrumb as $key => $value)
            <li class="breadcrumb-item"><a href="{{url($value)}}">{{$key}}</a></li>
            @endforeach
            <li class="breadcrumb-item active">{{$active}}</li>
        </ol>
    </div>
</div>
<div class="clearfix"></div>



