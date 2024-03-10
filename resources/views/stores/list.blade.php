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
                      <th class="text-center">Store</th>
                      <th class="text-center">Active</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($stores as $store)
                      <tr class="align-middle">
                        <td>{{$store->id}}</td>
                        <td class="text-center">
                          @if($store->image)
                            <img class="avatar-img" src="{{$store->image}}" alt="{{$store->alt}}" style="width: 100px;">
                          @endif
                        </td>
                        <td class="text-center">{{$store->name}}
                          <div class="small text-medium-emphasis">{{$store->address}}</div>
                        </td>
                        <td class="text-center">{{$store->active == 1 ? 'Yes' : ($store->active == 0 ? 'No' : '')}}
                          </td>
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                              </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="{{route('stores.show',$store->id )}}">Edit</a>

                              <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('p-form{{$store->id}}').submit()">Delete</a>
                              <form action="{{ route('stores.destroy', $store) }}" method="post" id="p-form{{$store->id}}">
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