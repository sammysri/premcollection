@extends('layout.main')
@section('content')


  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <!-- /.card.mb-4-->
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <strong>{{$title}}</strong>
              <!-- <span class="small ms-1">Basic example</span> -->
            </div>
            <div class="card-body">
              <div class="example">
                <p class="text-medium-emphasis small">
                  {{ $errors->first('password_error') }}
                </p>
                <form action="{{route('changePasswordPost')}}" method="post">
                    @csrf             

                    <div class="input-group mb-3"><span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span>
                        <input type="password" name="current_password" class="form-control" placeholder="Current Password" />
                    </div>
                    <p class="text-medium-emphasis small"><code>{{ $errors->first('current_password') }}</code></p>
                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span>
                        <input type="password" name="password" class="form-control" placeholder="New Password"/>
                    </div>
                    <p class="text-medium-emphasis small"><code>{{ $errors->first('password') }}</code></p>
                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"/>
                    </div>
                    <p class="text-medium-emphasis small"><code>{{ $errors->first('password_confirmation') }}</code></p>
                    <div class="row">
                      <div class="col-6">
                        <button class="btn btn-primary px-4" type="submit">Change Password</button>
                      </div>
                    </div>
                  </form>
              </div>              
            </div>
          </div>
        </div>  
      
      </div>
    </div>
  </div>
@endsection