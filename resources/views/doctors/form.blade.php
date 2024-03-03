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
                <p>
                  {{ $errors->first('doctor_error') }}
                </p>
                <form action="{{$doctor ? route('doctors.update', $doctor->id) : route('doctors.store')}}" method="post" enctype="multipart/form-data">
                  @csrf 
                  @if($doctor ) @method('PUT') @endif
                  <div class="form-floating mb-3">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name" value="{{$doctor ? $doctor->name : old('name')}}">
                    <label for="name">Name</label>
                    <p><code>
                      {{ $errors->first('name') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="degree" name="degree" type="text" placeholder="Enter Degree" value="{{$doctor ? $doctor->degree : old('degree')}}">
                    <label for="degree">Degree</label>
                    <p><code>
                      {{ $errors->first('degree') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="speciality" name="speciality" type="text" placeholder="Enter Speciality" value="{{$doctor ? $doctor->speciality : old('speciality')}}">
                    <label for="speciality">Speciality</label>
                    <p><code>
                      {{ $errors->first('speciality') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="experience" name="experience" type="text" placeholder="Enter Experience" value="{{$doctor ? $doctor->experience : old('experience')}}">
                    <label for="experience">Experience</label>
                    <p><code>
                      {{ $errors->first('experience') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="image" name="image" type="file">
                    <label for="image">Image</label>
                    <p><code>
                      {{ $errors->first('image') }}
                    </code></p>
                  </div>
                  @if($doctor && $doctor->image)
                    <div class="mb-3">
                        <img src="{{$doctor->image}}" style="width:100px; ">
                    </div>
                  @endif
                  <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" rows="6" placeholder="Description" name="description">{{$doctor ? $doctor->description : old('description')}}</textarea>
                    <p><code>
                      {{ $errors->first('description') }}
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