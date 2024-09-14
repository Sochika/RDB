<!-- Edit User Modal -->
<div class="modal" id="editStaff">
  <div class="modal-dialog modal-lg modal-simple modal-edit-staff">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Edit Staff Information</h4>
          <p>Updating staff details will receive a privacy audit.</p>
        </div>
        <form id="editStaffForm" class="row g-6" action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
         @csrf
          <div class="col-12 col-md-4">
            <label class="form-label" for="modalFirstName">First Name</label>
            <input type="text" id="modalFirstName" name="first_name" value="{{$staff->first_name}}" class="form-control" required />
          </div>
          <div class="col-12  col-md-4">
            <label class="form-label" for="modalMiddleName">Middle Name</label>
            <input type="text" id="modalMiddleName" name="middle_name" value="{{$staff->middle_name}}" class="form-control" />
          </div>
          <div class="col-12 col-md-4">
            <label class="form-label" for="modalLastName">Last Name</label>
            <input type="text" id="modalLastName" name="last_name" value="{{$staff->last_name}}" class="form-control" required/>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalPhoneNumber">Phone Number</label>
            <div class="input-group">
              <span class="input-group-text">NG (+234)</span>
              <input type="text" id="modalPhoneNumber" name="phone_number" class="form-control phone-number-mask" placeholder="{{$staff->phone_number}}" value="{{$staff->phone_number}}" required />
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="modalGender">Gender</label>
            <select id="modalGender" name="gender" class="select2 form-select" aria-label="Gender" required>
              <option @if($staff->gender == 'female') selected @endif value="female">Female</option>
              <option @if($staff->gender == 'male') selected @endif value="male">Male</option>
              <option @if($staff->gender == 'binary') selected @endif value="binary">Not Decided</option>

            </select>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalDateofBirth">Date of Birth</label>
            <input type="date" id="modalDateofBirth" name="date_of_birth" class="form-control" placeholder="example@domain.com" value="{{$staff->date_of_birth}}" required/>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEmail">Email</label>
            <input type="text" id="modalEmail" name="email" class="form-control" value="{{$staff->email}}" />
          </div>
          <div class="col-12">
            <label class="form-label" for="modalEditAddress">Address</label>
            <input type="text" id="modalEditAddress" name="address" class="form-control" value="{{$staff->address}}" required/>
          </div>
          <div class="col-6">
            <label class="form-label" for="modalEditArea">Area</label>
            <input type="text" id="modalEditArea" name="area" class="form-control" value="{{$staff->area}}" required/>
          </div>
          <div class="col-6">
            <label class="form-label" for="modalEditCity">City</label>
            <input type="text" id="modalEditCity" name="city" class="form-control" value="{{$staff->city}}" required/>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditStaffRole">Role</label>
            <select id="modalEditStaffRole" name="role_id" class="select2 form-select" aria-label="Default select example" required>

              @foreach ($roles as $role)
              <option @if ($staff->role_id == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
              @endforeach

            </select>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Shift</label>
            <select id="modalEditUserStatus" name="shifts_id" class="select2 form-select" aria-label="Default select example" disabled >

              <option value="">Select</option>
              @foreach ($shifts as $shift)
              <option @if ($staff->shift_id == $shift->id) selected @endif value="{{$shift->id}}">{{$shift->name}}</option>
              @endforeach

            </select>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserHiredDate">Hired Date</label>
            <input type="date" id="modalEditUserHiredDate" name="hire_date" class="form-control" value="{{$staff->hire_date}}" required/>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStaffNo">Employment No</label>
            <input type="text" id="modalEditUserStaffNo" name="staff_no" class="form-control" value="{{$staff->staff_no ?? ''}}" required/>
          </div>
          {{-- @if ($staff->graduated) --}}

          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserTerminted">Terminted Date</label>
            <input type="date" id="modalEditUserTerminted" name="graduated" class="form-control" readonly value="{{$staff->graduated}}" readonly/>
          </div>
          {{-- @endif --}}

          <div class="col-md-6 mb-6">
            <label class="form-label" for="formFilecredential">Upload Credentials</label>
            <input type="file" id="formFilecredential" class="form-control" name="credentials[]" multiple />
        </div>

        <div class="col-md-6 mb-6">
          <label class="form-label" for="profile_image">Choose Image</label>
          <input type="file" id="profile_image" class="form-control" name="avatar" accept="image/*" style="{{ $staff->avatar ? 'display: none;' : 'display: block;' }}" />
          <br>
          <img id="imagePreview" src="{{ $staff->avatar ? asset('images/'.$staff->avatar) : '#' }}" height="120" alt="Image Preview" style="{{ $staff->avatar ? 'display: block;' : 'display: none;' }}">
          <br>
          <button type="button" id="deleteImageButton" style="{{ $staff->avatar ? 'display: block;' : 'display: none;' }}">Delete Image</button>
        </div>



          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      const profileImageInput = document.getElementById('profile_image');
      const imagePreview = document.getElementById('imagePreview');
      const deleteImageButton = document.getElementById('deleteImageButton');

      // Function to preview the uploaded image
      profileImageInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  imagePreview.src = e.target.result;
                  imagePreview.style.display = 'block';
                  deleteImageButton.style.display = 'block';
                  profileImageInput.style.display = 'none';
              }
              reader.readAsDataURL(file);
          }
      });

      // Function to delete the existing image
      deleteImageButton.addEventListener('click', function() {
          // Clear image preview
          imagePreview.src = '#';
          imagePreview.style.display = 'none';

          // Hide the delete button
          deleteImageButton.style.display = 'none';

          // Show the profile image input
          profileImageInput.style.display = 'block';

          // Optionally, reset the file input (this may not be necessary depending on your use case)
          profileImageInput.value = '';
      });
  });
  </script>
  <!--/ Edit User Modal -->

<!--/ Edit User Modal -->
