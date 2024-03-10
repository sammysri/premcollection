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
                <p class="text-medium-emphasis small"><code>
                  {{ $errors->first('user_error') }}
                </code></p>
                <form action="{{$user ? url($type.'/management/'.$user->id) : url($type.'/management/') }}" method="post" enctype="multipart/form-data">
                  @csrf 
                  @if($user ) @method('PUT') @endif
                  <div class="form-floating mb-3">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name" value="{{$user ? $user->name : old('name')}}">
                    <label for="name">Name</label>
                    <p><code>
                      {{ $errors->first('name') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="email" name="email" type="text" placeholder="Enter Email" value="{{$user ? $user->email : old('email')}}">
                    <label for="email">Email</label>
                    <p><code>
                      {{ $errors->first('email') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="password" name="password" type="password" placeholder="Enter Password">
                    <label for="password">Password</label>
                    <p><code>
                      {{ $errors->first('password') }}
                    </code></p>
                  </div>
                  @if($user )
                    <div class="form-check">
                      <input class="form-check-input" id="reset_password" type="checkbox"  name="reset_password" value="1">
                      <label class="form-check-label" for="reset_password">Reset Password</label>
                    </div>
                  @endif
                  <div class="mb-3">
                    <label for="active">Active</label>
                    <select class="form-control" id="active" name="active">
                      <option value="0" {{ $user && $user->active == 0 ? 'selected' : '' }}>No</option>
                      <option value="1" {{ $user && $user->active == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    <p><code>
                      {{ $errors->first('active') }}
                    </code></p>
                  </div>
                  <button class="btn btn-primary" type="submit">Save</button>
                </form>
              </div>              
            </div>
          </div>
        </div>  
      
      </div>
    </div>
  </div>
@endsection