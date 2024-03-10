@extends('layout.main')
@section('content')


  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <!-- /.card.mb-4-->
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <strong>Add New Image in {{$album->name}} Album</strong>
              <!-- <span class="small ms-1">Basic example</span> -->
            </div>
            <div class="card-body">
              <div class="example">
                <p class="text-medium-emphasis small"><code>
                  {{ $errors->first('image_error') }}
                </code></p>
                <form action="{{ route('albumImagePost', $album->id) }}" method="post" enctype="multipart/form-data">
                  @csrf 
                  <div class="form-floating mb-3">
                    <input class="form-control" id="alt" name="alt" type="text" placeholder="Enter Alt" value="{{ old('alt')}}">
                    <label for="name">Alt Tag</label>
                    <p><code>
                      {{ $errors->first('alt') }}
                    </code></p>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="image" name="image" type="file">
                    <label for="image">Base Image</label>
                    <p><code>
                      {{ $errors->first('image') }}
                    </code></p>
                  </div>
                  <button class="btn btn-primary" type="submit">Save</button>
                </form>
              </div>  
              
              <div class="example">
                <div class="table-responsive">
                  <table class="table border mb-0">
                    <thead class="table-light fw-semibold">
                      <tr class="align-middle">
                        <th class="text-center">
                          #
                        </th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Alt</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($images as $_image)
                        <tr class="align-middle">
                          <td>{{$_image->id}}</td>
                          <td class="text-center">
                            @if($_image->image)
                              <img class="avatar-img" src="{{$_image->image}}" alt="{{$_image->alt}}" style="width: 100px;">
                            @endif
                          </td>
                          <td class="text-center">{{$_image->alt}}
                          </td>
                          <td>
                            <a class="dropdown-item text-danger" href="javascript:void(0);" style="cursor: pointer;"  onclick="document.getElementById('p-form{{$_image->id}}').submit()">Delete</a>
                              <form action="{{ route('albumImageDelete', ['id' => $album->id, 'imageId' => $_image->id]) }}" method="post" id="p-form{{$_image->id}}">
                                @method('DELETE')
                                @csrf
                              </form>
                            </a>
                          </td>
                        </tr>
                      @empty
                        <tr><td clospan="5">No records found.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>  
              

            </div>
          </div>
        </div>  
      
      </div>
    </div>
  </div>
@endsection