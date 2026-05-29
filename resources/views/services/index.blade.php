<x-app-layout>
        <style>
            .navbar-transparent {
    background-color: #2a2a2a !important;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 299;
    transition: all 0.25s;
    -webkit-transition: all 0.25s;
}
@media (max-width: 767px) {
    /* Stack columns vertically, override the row-reverse !important */
    .serviceslisting li,
    .serviceslisting li:nth-child(2n) { flex-direction: column !important; }
    /* Remove side padding that shifts content off-center */
    .servtext,
    .serviceslisting li:nth-child(2n) .servtext { padding: 20px 0 0 !important; }
    /* h4 uses display:flex — must use justify-content, not text-align */
    .servtext h4 { justify-content: center !important; font-size: 22px !important; flex-wrap: nowrap !important; white-space: nowrap; }
    .servtext h4 i { font-size: 20px !important; margin-right: 10px !important; }
    /* Everything else */
    .servtext p { text-align: center !important; }
    .serviceslisting li .readmore { text-align: center !important; }
    .readmore .btn { display: block !important; width: 100% !important; }
}
        </style>

<div class="pageheader">            
            <div class="container">
            <?php $widget =widget(19); ?>
                <h1>Our Services</h1>
                <p>{{$widget->description}}</p>
            </div>
      </div>


        
        <!-- End #header -->
    
        <div id="content" role="main" class="no-padding">
        
            <div class="bg-lightergray no-overflow py-5">

                <div class="container ">
                            <ul class="serviceslisting">

                                @if(null!==($services))
                                @foreach($services as $service)
                               


                                <li class="row">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="servpostimg">
                                            <img src="{{asset('images/'.$service->image)}}" alt="{{$service->getTranslatedExtraField(2)}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="servtext">
                                            <h4>{!!$service->getTranslatedExtraField(1)!!} <span>{{$service->getTranslatedTitle()}}</span></h4>
                                            <p>{!! Str::limit($service->description, 600) !!}</p>

                                            <div class="readmore">
                                                <a href="{{route('services.detail',$service->slug)}}" class="btn btn-primary">Read More</a>
                                            </div>
                                        </div>
                                    </div>                    
                                </li>






                                @endforeach
                                @endif
                            </ul>

                                <!-- End .col-sm-6 -->
                           
                    </div>
                </div>
            </div>
</div>
</x-app-layout>