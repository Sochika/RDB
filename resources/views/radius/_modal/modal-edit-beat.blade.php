<!-- Add New Address Modal -->
<div class="modal fade" id="editBeatModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="address-title mb-2">Edit Beat</h4>
          <p class="address-subtitle">Edit beat Details</p>
        </div>
        <form id="addNewAddressForm" class="row g-6" action="{{ route('beats.store') }}" method="POST">
          @csrf

          <div class="col-12">
            <label class="form-label" for="companyName">Company Name</label>
            <input type="text" id="companyName" name="companyName" class="form-control" placeholder="St. Odumo" value="{{$beat->name}}"/>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalAddressFirstName">Contact First Name</label>
            <input type="text" id="modalAddressFirstName" name="first_name" class="form-control" required placeholder="John" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalAddressLastName">Contact Last Name</label>
            <input type="text" id="modalAddressLastName" name="last_name" class="form-control" required placeholder="Doe" />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="phone_number">Contact Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" required placeholder="08095000000" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="email">Contact Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="johndoe@example.com" />
          </div>

          <div class="col-12">
            <label class="form-label" for="modalAddressAddress1">Address Line 1</label>
            <input type="text" id="modalAddressAddress1" name="Address1" class="form-control" required placeholder="12, Business Park" />
          </div>
          <div class="col-12">
            <label class="form-label" for="modalAddressAddress2">Address Line 2</label>
            <input type="text" id="modalAddressAddress2" name="Address2" class="form-control" placeholder="Mall Road" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalAddressArea">Area</label>
            <input type="text" id="modalAddressArea" name="area" class="form-control" placeholder="Rumumaosi" required />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalAddressLandmark">Landmark</label>
            <input type="text" id="modalAddressLandmark" name="landmark" class="form-control" placeholder="Nr. First Bank" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalAddressCity">City</label>
            <input type="text" id="modalAddressCity" name="city" class="form-control" placeholder="Port Harcourt" />
          </div>
          <div class="col-md-6 mb-6">
            <label for="selectpickerLiveSearch" class="form-label">State</label>
            <select id="selectpickerLiveSearch" class="form-select selectpicker w-100" name="state" data-style="btn-default" data-live-search="true">
              <option data-tokens="none">Select</option>
              @foreach ($states as $state)
              <option data-tokens="{{ $state->name }}">{{ $state->name }}</option>
              @endforeach
            </select>
          </div>



          <div class="col-12 col-md-6">
            <label class="form-label" for="onboard_date">OnBoard Date</label>
            <input type="date" id="onboard_date" name="onboard_date" class="form-control" placeholder="Port Harcourt" />
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
<!--/ Add New Address Modal -->
