<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$page_title??''}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach ($breadcrumb as $item)
                        <li class="breadcrumb-item {{is_null($item['url'] ? 'active':'')}}">
                            @if(isset($item['url']) && !empty($item['url']))
                                <a href="{{$item['url']??'#'}}">
                                    {{ucwords($item['name'])}}
                                </a>
                            @else
                                {{ucwords($item['name'])}}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>
