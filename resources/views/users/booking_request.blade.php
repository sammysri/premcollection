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
                      <th class="text-center">User</th>
                      <th class="text-center">Service</th>
                      <th class="text-center">Details</th>
                      <th class="text-center">Booked On</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($_bookedServices as $_service)
                      <tr class="align-middle">
                        <td>{{$_service['id']}}</td>
                        <td class="text-center" >{{$_service['user_name']}}</td>
                        <td class="text-center" >
                            {{$_service['service_type']}}
                            @if($_service['service_type'] != 'DinnerMenu' || $_service['service_type'] != 'Car')<div class="small text-medium-emphasis">{{$_service['service']['name']}}</div> @endif
                        </td>
                        <td class="text-center" >
                            @foreach($_service['extra_data'] as $_serviceKey => $_serviceData)
                                <p>{{$_serviceKey}}: {{$_serviceData}}</p>
                            @endforeach
                        </td>
                        <td class="text-center" >{{$_service['booked_on']}}</td>
                        <td>
                            <form action="{{ route('bookedServiceStatusChange', $_service['id']) }}" method="post" id="p-form{{$_service['id']}}">
                                @csrf
                                <div class="input-group mb-3">
                                    <select class="form-select" name="status">
                                        <option value="under-process" {{$_service['status'] == "under-process" ? 'selected' : ''}}>Under-process</option>
                                        <option value="cancelled" {{$_service['status'] == "cancelled" ? 'selected' : ''}}>Cancelled</option>
                                        <option value="confirmed" {{$_service['status'] == "confirmed" ? 'selected' : ''}}>Confirmed</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">Change</button>
                                </div>
                            </form>
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