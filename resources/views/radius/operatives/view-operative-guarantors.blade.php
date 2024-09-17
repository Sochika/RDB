@extends('radius/operatives/view-operative')
@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/themify-icons/themify-icons.css') }}">
@endsection
@section('operative-content')
    <div class="nav-align-top">
        <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
            <li class="nav-item"><a class="nav-link " href="{{ route('staff-view', ['id' => $staff->id]) }}"><i
                        class="ti ti-user-check ti-sm me-1_5"></i>Attendances</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('staff-activity', ['id' => $staff->id]) }}"><i
                        class="ti ti-lock ti-sm me-1_5"></i>Work History</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('staff-guarantors', ['id' => $staff->id]) }}"><i
                        class="ti ti-lock ti-sm me-1_5"></i>Guarantors</a></li>
            {{-- <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/notifications')}}"><i class="ti ti-bell ti-sm me-1_5"></i>Notifications</a></li> --}}
            {{-- <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/connections')}}"><i class="ti ti-link ti-sm me-1_5"></i>Connections</a></li> --}}
        </ul>
    </div>
    <div class="card">
      <div class="container">
          <div class="body d-flex py-lg-3 py-md-2">
              <div class="pt-6">
                  <a href="javascript:;" class="btn btn-info me-4" id="addGuarantorBtn" data-bs-target="#modalGuarantor" data-bs-toggle="modal">Add Guarantor</a>
              </div>
          </div>
          <div class="container-xxl">
              <div class="container mt-5">
                  <h1 class="mb-4">Guarantors List</h1>
                  @if ($staff->guarantors->isEmpty())
                      <p>No guarantors found.</p>
                  @else
                      <div class="table-responsive">
                          <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>First Name</th>
                                      <th>Middle Name</th>
                                      <th>Last Name</th>
                                      <th>Phone Number</th>
                                      <th>Email</th>
                                      <th>Address</th>
                                      <th>Image</th>
                                      <th>ID</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($staff->guarantors as $guarantor)
                                      <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $guarantor->first_name }}</td>
                                          <td>{{ $guarantor->middle_name }}</td>
                                          <td>{{ $guarantor->last_name }}</td>
                                          <td>{{ $guarantor->phone_number }}</td>
                                          <td>{{ $guarantor->email }}</td>
                                          <td>{{ $guarantor->address }}</td>
                                          <td>
                                              @if ($guarantor->avatar)
                                                  <img src="{{ asset('storage/' . $guarantor->avatar) }}" alt="Avatar" class="img-fluid" style="max-width: 100px;">
                                              @else
                                                  No Image
                                              @endif
                                          </td>
                                          <td>
                                              @if ($guarantor->ID_document)
                                                  @if (str_ends_with($guarantor->ID_document, '.pdf'))
                                                      <a href="{{ asset('storage/' . $guarantor->ID_document) }}" target="_blank">View PDF</a>
                                                  @else
                                                      <img src="{{ asset('storage/' . $guarantor->ID_document) }}" alt="Credential" class="img-fluid" style="max-width: 100px;">
                                                  @endif
                                              @else
                                                  No ID
                                              @endif
                                          </td>
                                          <td>
                                              <form action="{{ route('guarantors.destroy', $guarantor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this guarantor?');">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                              </form>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  @endif
              </div>
          </div>
      </div>
  </div>




    <!-- Modal -->
    @include('radius/_modal/modal-add-guarantor')

    <!-- /Modal -->
@endsection
