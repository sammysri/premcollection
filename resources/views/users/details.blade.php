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
                  {{ $errors->first('details_error') }}
                </code></p>
                <form action="{{ route('userDetailsPost', $user->id) }}" method="post" enctype="multipart/form-data">
                  @csrf 
                  <div class="form-floating mb-3">
                    <input class="form-control" id="phone" name="phone" type="text" placeholder="Enter phone" value="{{$details ? $details->phone : old('phone')}}">
                    <label for="name">Phone</label>
                    <p><code>
                      {{ $errors->first('phone') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="whatsapp" name="whatsapp" type="text" placeholder="Enter Whatsapp" value="{{$details ? $details->whatsapp : old('whatsapp')}}">
                    <label for="name">Whatsapp</label>
                    <p><code>
                      {{ $errors->first('whatsapp') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="card_number" name="card_number" type="text" placeholder="Enter Card Number" value="{{$details ? $details->card_number : old('card_number')}}">
                    <label for="name">Card Number</label>
                    <p><code>
                      {{ $errors->first('card_number') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="dob" name="dob" type="date" placeholder="Enter DOB" value="{{$details ? $details->dob : old('dob')}}">
                    <label for="name">DOB</label>
                    <p><code>
                      {{ $errors->first('dob') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="address" name="address" type="text" placeholder="Enter Address" value="{{$details ? $details->address : old('address')}}">
                    <label for="name">Address</label>
                    <p><code>
                      {{ $errors->first('address') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="bio" name="bio" type="text" placeholder="Enter BIO" value="{{$details ? $details->bio : old('bio')}}">
                    <label for="name">BIO</label>
                    <p><code>
                      {{ $errors->first('bio') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="club_name" name="club_name" type="text" placeholder="Enter Club Name" value="{{$details ? $details->club_name : old('club_name')}}">
                    <label for="name"> Club Name</label>
                    <p><code>
                      {{ $errors->first('club_name') }}
                    </code></p>
                  </div>

                  <div class="mb-3">
                    <label for="store_id">Store</label>
                    <select class="form-control" id="store_id" name="store_id" >
                      <option value="">Select</option>
                      @foreach($stores as $_storek => $_storev)
                      <option value="{{$_storek}}" {{ $details && $details->store_id == $_storek ? 'selected' : '' }}>{{$_storev}}</option>
                      @endforeach
                    </select>
                    <p><code>
                      {{ $errors->first('store_id') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="image" name="image" type="file">
                    <label for="image">Image</label>
                    <p><code>
                      {{ $errors->first('image') }}
                    </code></p>
                  </div>
                  @if($details && $details->image)
                    <div class="mb-3">
                        <img src="{{$details->image}}" style="width:100px; ">
                    </div>
                  @endif
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