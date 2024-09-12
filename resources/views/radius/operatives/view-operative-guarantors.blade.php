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
                <div class="container-xxl">
                  Guarantors data
                </div>
            </div>
        </div>
    </div>
@endsection


