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
                  {{ $errors->first('hotel_error') }}
                </code></p>
                <form action="{{$hotel ? route('hotels.update', $hotel->id) : route('hotels.store')}}" method="post" enctype="multipart/form-data">
                  @csrf 
                  @if($hotel ) @method('PUT') @endif
                  <div class="form-floating mb-3">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name" value="{{$hotel ? $hotel->name : old('name')}}">
                    <label for="name">Name</label>
                    <p><code>
                      {{ $errors->first('name') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="address" name="address" type="text" placeholder="Enter Address" value="{{$hotel ? $hotel->address : old('address')}}">
                    <label for="address">Address</label>
                    <p><code>
                      {{ $errors->first('address') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="price" name="price" type="number" placeholder="Enter Price" value="{{$hotel ? $hotel->price : old('price')}}">
                    <label for="price">Price</label>
                    <p><code>
                      {{ $errors->first('price') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="image" name="image" type="file">
                    <label for="image">Image</label>
                    <p><code>
                      {{ $errors->first('image') }}
                    </code></p>
                  </div>
                  @if($hotel && $hotel->image)
                    <div class="mb-3">
                        <img src="{{$hotel->image}}" style="width:100px; ">
                    </div>
                  @endif
                  <!-- <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" rows="6" placeholder="Description" name="description">{{$hotel ? $hotel->description : old('description')}}</textarea>
                    <p><code>
                      {{ $errors->first('description') }}
                    </code></p>
                  </div> -->
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