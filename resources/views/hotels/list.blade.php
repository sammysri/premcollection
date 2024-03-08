@extends('layout.main')
@section('content')


  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <!-- /.card.mb-4-->
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <!-- <div class="card-header">Traffic &amp; Sales</div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table border mb-0">
                  <thead class="table-light fw-semibold">
                    <tr class="align-middle">
                      <th class="text-center">
                        #
                      </th>
                      <th class="text-center">Image</th>
                      <th class="text-center">Hotel</th>
                      <!-- <th class="text-center">Description</th> -->
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($hotels as $hotel)
                      <tr class="align-middle">
                        <td>{{$hotel->id}}</td>
                        <td class="text-center">
                          <div class="avatar avatar-md">
                            <img class="avatar-img" src="{{$hotel->image}}" alt="{{$hotel->name}}">
                          </div>
                        </td>
                        <td>{{$hotel->name}}
                          <div class="small text-medium-emphasis">{{$hotel->address}}</div>
                          <div class="fw-semibold">{!! $hotel->price_text !!}</div>
                        </td>
                        {{-- <td>{{$hotel->description}}</td> --}}
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                              </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <!-- <a class="dropdown-item" href="#">Info</a> -->
                              <a class="dropdown-item" href="{{route('hotels.show',$hotel->id )}}">Edit</a>

                              <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('p-form{{$hotel->id}}').submit()">Delete</a>
                              <form action="{{ route('hotels.destroy', $hotel) }}" method="post" id="p-form{{$hotel->id}}">
                                @csrf
                                @method('DELETE')
                              </form>

                            </div>
                          </div>
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
@endsection