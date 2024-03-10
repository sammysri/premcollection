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
                      <th class="text-center">Menu</th>
                      <!-- <th class="text-center">Description</th> -->
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($dinnerMenus as $menu)
                      <tr class="align-middle">
                        <td>{{$menu->id}}</td>
                        <td class="text-center">
                          @if($menu->image)
                            <div class="avatar avatar-md">
                              <img class="avatar-img" src="{{$menu->image}}" alt="{{$menu->name}}">
                              @if($menu->active == 1)
                              <span class="avatar-status bg-success"></span>
                              @elseif($menu->active == 0)
                              <span class="avatar-status bg-danger"></span>
                              @else @endif
                            </div>
                          @endif
                        </td>
                        <td class="text-center">{{$menu->name}}
                        </td>
                        {{-- <td>{{$menu->description}}</td> --}}
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                              </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <!-- <a class="dropdown-item" href="#">Info</a> -->
                              <a class="dropdown-item" href="{{route('dinner-menus.show',$menu->id )}}">Edit</a>

                              <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('p-form{{$menu->id}}').submit()">Delete</a>
                              <form action="{{ route('dinner-menus.destroy', $menu) }}" method="post" id="p-form{{$menu->id}}">
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