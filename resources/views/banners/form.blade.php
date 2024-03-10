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
                  {{ $errors->first('banner_error') }}
                </code></p>
                <form action="{{$banner ? route('banners.update', $banner->id) : route('banners.store')}}" method="post" enctype="multipart/form-data">
                  @csrf 
                  @if($banner ) @method('PUT') @endif
                  <div class="form-floating mb-3">
                    <input class="form-control" id="alt" name="alt" type="text" placeholder="Enter Alt" value="{{$banner ? $banner->alt : old('alt')}}">
                    <label for="alt">Alt</label>
                    <p><code>
                      {{ $errors->first('alt') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="priority" name="priority" type="text" placeholder="Enter Priority" value="{{$banner ? $banner->priority : old('priority')}}">
                    <label for="priority">Priority</label>
                    <p><code>
                      {{ $errors->first('priority') }}
                    </code></p>
                  </div>
                  <div class="mb-3">
                    <label for="active">Active</label>
                    <select class="form-control" id="active" name="active">
                      <option value="0" {{ $banner && $banner->active == 0 ? 'selected' : '' }}>No</option>
                      <option value="1" {{ $banner && $banner->active == 1 ? 'selected' : '' }}>Yes</option>
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
                  @if($banner && $banner->image)
                    <div class="mb-3">
                        <img src="{{$banner->image}}" style="width:100px; ">
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