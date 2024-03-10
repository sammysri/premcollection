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
                  {{ $errors->first('category_error') }}
                </code></p>
                <form action="{{ route('categoryPost', $category->id) }}" method="post">
                  @csrf 
                  <div class="form-floating mb-3">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name" value="{{$category->id ? $category->name : old('name')}}">
                    <label for="name">Name</label>
                    <p><code>
                      {{ $errors->first('name') }}
                    </code></p>
                  </div>
                  <div class="mb-3">
                    <label for="active">Active</label>
                    <select class="form-control" id="active" name="active">
                      <option value="0" {{ $category && $category->active == 0 ? 'selected' : '' }}>No</option>
                      <option value="1" {{ $category && $category->active == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    <p><code>
                      {{ $errors->first('active') }}
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
                        <th class="text-center">Category</th>
                        <th class="text-center">Active</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($categories as $_category)
                        <tr class="align-middle">
                          <td>{{$_category->id}}</td>
                          <td>{{$_category->name}}
                          </td>
                          <td>{{$_category->active == 1 ? 'Yes' : ($_category->active == 0 ? 'No' : '')}}
                          </td>
                          <td>
                            <a class="dropdown-item" href="{{route('category',$_category->id )}}">Edit</a>
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