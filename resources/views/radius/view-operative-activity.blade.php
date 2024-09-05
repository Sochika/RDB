@extends('radius/view-operative')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/themify-icons/themify-icons.css')}}">
@endsection
@section('operative-content')
            <!-- User Pills -->
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
                    <li class="nav-item"><a class="nav-link" href="{{ route('staff-view', ['id' => $staff->id]) }}"><i
                                class="ti ti-user-check ti-sm me-1_5"></i>Attendances</a></li>
                    <li class="nav-item"><a class="nav-link active"
                            href="{{ route('staff-activity', ['id' => $staff->id]) }}"><i
                                class="ti ti-lock ti-sm me-1_5"></i>Work History</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/notifications')}}"><i class="ti ti-bell ti-sm me-1_5"></i>Notifications</a></li> --}}
                    {{-- <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/connections')}}"><i class="ti ti-link ti-sm me-1_5"></i>Connections</a></li> --}}
                </ul>
            </div>
            <!--/ User Pills -->

            {{-- <!-- Project table -->
    <div class="card mb-6">
      <div class="card-datatable table-responsive">
        <table class="datatables-projects table border-top">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>Project</th>
              <th>Leader</th>
              <th>Team</th>
              <th class="w-px-200">Progress</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!-- /Project table --> --}}

            <div class="card mb-6">
                <h5 class="card-header">Shit History</h5>
                <div class="table-responsive table-border-bottom-0">
                    <table class="table">
                        <thead>
                            <tr>

                                <th class="text-truncate">Beat</th>
                                <th class="text-truncate">Shift</th>
                                <th class="text-truncate">Main Shift</th>
                                <th class="text-truncate">Comment</th>
                                <th class="text-truncate">Rate</th>
                                <th class="text-truncate">Shift Started</th>
                                <th class="text-truncate">Shift Ended</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if ($shifts)
                          @foreach ($shifts as $shift)

                          <tr>
                            <td>{{$shift->beatBranch->name}}</td>
                            <td>{{$shift->shiftType->name}}</td>
                            <td>{{$shift->main_assign ? 'Main' : 'Extra'}}</td>
                            <td>{{$shift->comment ?? ''}}</td>
                            <td>{{$shift->rate ?? ''}}</td>
                            <td>{{ \Carbon\Carbon::parse($shift->shift_date_start)->format('l, j F, Y') }}</td>
                            <td>{{$shift->expires ?? 'Current'}}</td>
                          </tr>
                          @endforeach

                          @else

                          @endif
                            {{-- <tr>
                                <td class="text-truncate"><i class='ti ti-brand-windows ti-md text-info me-4'></i> <span
                                        class="text-heading">Chrome on Windows</span></td>
                                <td class="text-truncate">HP Spectre 360</td>
                                <td class="text-truncate">Switzerland</td>
                                <td class="text-truncate">10, July 2021 20:07</td>
                            </tr>
                            <tr>
                                <td class="text-truncate"><i class='ti ti-device-mobile ti-md text-danger me-4'></i> <span
                                        class="text-heading">Chrome on iPhone</span></td>
                                <td class="text-truncate">iPhone 12x</td>
                                <td class="text-truncate">Australia</td>
                                <td class="text-truncate">13, July 2021 10:10</td>
                            </tr>
                            <tr>
                                <td class="text-truncate"><i class='ti ti-brand-android ti-md text-success me-4'></i>
                                    <span class="text-heading">Chrome on Android</span>
                                </td>
                                <td class="text-truncate">Oneplus 9 Pro</td>
                                <td class="text-truncate">Dubai</td>
                                <td class="text-truncate">14, July 2021 15:15</td>
                            </tr>
                            <tr>
                                <td class="text-truncate"><i class='ti ti-brand-apple ti-md me-4'></i> <span
                                        class="text-heading">Chrome on MacOS</span></td>
                                <td class="text-truncate">Apple iMac</td>
                                <td class="text-truncate">India</td>
                                <td class="text-truncate">16, July 2021 16:17</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>

            @endsection
