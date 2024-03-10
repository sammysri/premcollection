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
                  {{ $errors->first('car_error') }}
                </code></p>
                <form action="{{$car ? route('cars.update', $car->id) : route('cars.store')}}" method="post" enctype="multipart/form-data">
                  @csrf 
                  @if($car ) @method('PUT') @endif
                  <div class="form-floating mb-3">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name" value="{{$car ? $car->name : old('name')}}">
                    <label for="name">Name</label>
                    <p><code>
                      {{ $errors->first('name') }}
                    </code></p>
                  </div>
                  <div class="mb-3">
                    <label for="active">Active</label>
                    <select class="form-control" id="active" name="active">
                      <option value="0" {{ $car && $car->active == 0 ? 'selected' : '' }}>No</option>
                      <option value="1" {{ $car && $car->active == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    <p><code>
                      {{ $errors->first('active') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="image" name="image" type="file">
                    <label for="image">Image</label>
                    <p><code>
                      {{ $errors->first('image') }}
                    </code></p>
                  </div>
                  @if($car && $car->image)
                    <div class="mb-3">
                        <img src="{{$car->image}}" style="width:100px; ">
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