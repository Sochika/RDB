<table class="table">
  <thead>
      <tr>
          <th>Operative</th>
          <th>Phone Number</th>
          <th>Beat Location</th>
          <th>Shift Time</th>
          <th>Shift Type</th>
          <th>Comment</th>
          <th>Lateness (minutes)</th>
          <th>Present</th>
      </tr>
  </thead>
  <tbody>
      @php $currentShiftType = null; @endphp
      @foreach ($staffsUnMarked as $staff)
          @if ($currentShiftType !== $staff->shift_type_name)
              @php $currentShiftType = $staff->shift_type_name; @endphp
              <tr class="group-title">
                  <td colspan="8"><strong>{{ $currentShiftType }}</strong></td>
              </tr>
          @endif
          <tr>
              <td><a href="{{ route('staff-view', ['id' => $staff->id]) }}">{{ $staff->first_name }} {{ $staff->last_name }}</a></td>
              <td>{{ $staff->phone_number }}</td>
              <td>{{ $staff->beat_branch_name }}</td>
              <td>{{ date('h:i A', strtotime($staff->shift_start ?? '--')) }}</td>
              <td>{{ $staff->shift_type_name }}</td>
              <td>
                  <input type="text" name="comment[{{ $staff->id }}]" class="form-control comment-input">
              </td>
              <td>
                  <input type="number" name="lateness[{{ $staff->id }}]" class="form-control lateness-input" value="0" min="0">
              </td>
              <td>
                  <div class="col-md-6">
                      <label class="switch switch-success">
                          <input type="checkbox" class="switch-input" name="view_off_beats" data-staff-id="{{ $staff->id }}" />
                          <span class="switch-toggle-slider">
                              <span class="switch-on">
                                  <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                  <i class="ti ti-x"></i>
                              </span>
                          </span>
                      </label>
                  </div>
                  <input type="hidden" name="staff_id" value="{{ $staff->id }}">
                  <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
              </td>
          </tr>
      @endforeach
  </tbody>
</table>
