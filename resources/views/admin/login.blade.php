@extends('admin.layout.master')
@section('content')

@section('nav-side')
@show


<div class="peers ai-s fxw-nw h-100vh">
    <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv"
         style="background-image:url({{url('admin/static/images/bg.jpg')}})">
        <div class="pos-a centerXY">
            <div class="bgc-white bdrs-50p pos-r" style="width:160px;height:160px"><img style="width:110px;height:110px" class="img-circle pos-a centerXY"
                                                                                        src="https://scontent-cai1-1.xx.fbcdn.net/v/t1.0-1/15616_572058609596254_8563595312590805004_n.png?_nc_cat=0&oh=a343176b82afedc01148b30b1c4cfb7b&oe=5B4E8625"
                                                                                        alt=""></div>
        </div>
    </div>
    <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width:320px"><h4
                class="fw-300 c-grey-900 mB-40">Login</h4>
        <form>
            <div class="form-group"><label class="text-normal text-dark">Username</label> <input type="email"
                                                                                                 class="form-control"
                                                                                                 placeholder="John Doe">
            </div>
            <div class="form-group"><label class="text-normal text-dark">Password</label> <input type="password"
                                                                                                 class="form-control"
                                                                                                 placeholder="Password">
            </div>
            <div class="form-group">
                <div class="peers ai-c jc-sb fxw-nw">
                    <div class="peer">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c"><input type="checkbox"
                                                                                              id="inputCall1"
                                                                                              name="inputCheckboxesCall"
                                                                                              class="peer"> <label
                                    for="inputCall1" class="peers peer-greed js-sb ai-c"><span
                                        class="peer peer-greed">Remember Me</span></label>
                        </div>
                    </div>
                    <div class="peer">
                        <button class="btn btn-primary">Login</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection