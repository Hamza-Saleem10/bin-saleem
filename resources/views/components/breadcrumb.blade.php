<div class="page-header ">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    @if(@$button['allow'])
                        <a href="{{ $button['link'] }}" class="btn btn-primary font-weight-bold btn-sm px-4 font-size-base ml-2 float-end">{{ $button['name'] }}</a>
                    @endif
                    <h5 class="m-b-10">{{$title}}</h5>
                </div>
                
                
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                    @if(!empty($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            @if(@$breadcrumb['allow'])
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['name'] }}</a>
                            </li>
                            @endif
                        @endforeach
                    @else
                    <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>