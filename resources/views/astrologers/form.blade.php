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
                  {{ $errors->first('astrologer_error') }}
                </code></p>
                <form action="{{$astrologer ? route('astrologers.update', $astrologer->id) : route('astrologers.store')}}" method="post" enctype="multipart/form-data">
                  @csrf 
                  @if($astrologer ) @method('PUT') @endif
                  <div class="form-floating mb-3">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name" value="{{$astrologer ? $astrologer->name : old('name')}}">
                    <label for="name">Name</label>
                    <p><code>
                      {{ $errors->first('name') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="experience" name="experience" type="text" placeholder="Enter Experience" value="{{$astrologer ? $astrologer->experience : old('experience')}}">
                    <label for="experience">Experience</label>
                    <p><code>
                      {{ $errors->first('experience') }}
                    </code></p>
                  </div>
                  <div class="mb-3">
                    <label for="active">Active</label>
                    <select class="form-control" id="active" name="active">
                      <option value="0" {{ $astrologer && $astrologer->active == 0 ? 'selected' : '' }}>No</option>
                      <option value="1" {{ $astrologer && $astrologer->active == 1 ? 'selected' : '' }}>Yes</option>
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
                  @if($astrologer && $astrologer->image)
                    <div class="mb-3">
                        <img src="{{$astrologer->image}}" style="width:100px; ">
                    </div>
                  @endif
                  <!-- <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" rows="6" placeholder="Description" name="description">{{$astrologer ? $astrologer->description : old('description')}}</textarea>
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