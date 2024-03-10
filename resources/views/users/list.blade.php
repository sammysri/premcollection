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
                      <th class="text-center">Name</th>
                      <th class="text-center">Email</th>
                        <th class="text-center">Active</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($users as $user)
                      <tr class="align-middle">
                        <td>{{$user->id}}</td>
                        <td class="text-center">{{$user->name}}</td>
                        <td class="text-center">{{$user->email}}</td>
                        <td class="text-center">{{$user->active == 1 ? 'Yes' : ($user->active == 0 ? 'No' : '')}}
                          </td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg class="icon">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                              </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <!-- <a class="dropdown-item" href="#">Info</a> -->
                              <a class="dropdown-item" href="{{url($type.'/management/'.$user->id)}}">Edit</a>
                              <a class="dropdown-item" href="{{route('userDetails',$user->id)}}">Details</a>

                              <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('p-form{{$user->id}}').submit()">Delete</a>
                              <form action="{{url($type.'/management/'.$user->id)}}" method="post" id="p-form{{$user->id}}">
                                @csrf
                                @method('DELETE')
                              </form>

                            </div>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr><td clospan="4">No records found.</td></tr>
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