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
                      <th class="text-center">Car</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($cars as $car)
                      <tr class="align-middle">
                        <td>{{$car->id}}</td>
                        <td class="text-center">
                          @if($car->image)
                            <div class="avatar avatar-md">
                              <img class="avatar-img" src="{{$car->image}}" alt="{{$car->name}}">
                              @if($car->active == 1)
                              <span class="avatar-status bg-success"></span>
                              @elseif($car->active == 0)
                              <span class="avatar-status bg-danger"></span>
                              @else @endif
                            </div>
                          @endif
                        </td>
                        <td class="text-center">{{$car->name}}</td>
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                              </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="{{route('cars.show',$car->id )}}">Edit</a>

                              <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('p-form{{$car->id}}').submit()">Delete</a>
                              <form action="{{ route('cars.destroy', $car) }}" method="post" id="p-form{{$car->id}}">
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