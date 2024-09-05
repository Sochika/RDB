<!-- Add New Address Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="address-title mb-2">Add New Beat Branch for {{ $beat->name }}</h4>
          <p class="address-subtitle">Add Beat Branch Details</p>
        </div>
        <form id="addNewAddressForm" class="row g-6" action="{{ route('beatBranch.add') }}" method="POST">
          @csrf

          <div class="col-12">
            <div class="row">
              <div class="col-md mb-md-0 mb-4">
                <div class="form-check custom-option custom-option-icon">
                  <label class="form-check-label custom-option-content" for="customRadioHome">
                    <span class="custom-option-body">
                      <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.2" d="M16.625 23.625V16.625H11.375V23.625H4.37501V12.6328C4.37437 12.5113 4.39937 12.391 4.44837 12.2798C4.49737 12.1686 4.56928 12.069 4.65939 11.9875L13.4094 4.03592C13.5689 3.88911 13.7778 3.80762 13.9945 3.80762C14.2113 3.80762 14.4202 3.88911 14.5797 4.03592L23.3406 11.9875C23.4287 12.0706 23.4992 12.1706 23.548 12.2814C23.5969 12.3922 23.6231 12.5117 23.625 12.6328V23.625H16.625Z" />
                        <path d="M23.625 23.625V12.6328C23.623 12.5117 23.5969 12.3922 23.548 12.2814C23.4992 12.1706 23.4287 12.0706 23.3406 11.9875L14.5797 4.03592C14.4202 3.88911 14.2113 3.80762 13.9945 3.80762C13.7777 3.80762 13.5689 3.88911 13.4094 4.03592L4.65937 11.9875C4.56926 12.069 4.49736 12.1686 4.44836 12.2798C4.39936 12.391 4.37436 12.5113 4.375 12.6328V23.625M1.75 23.625H26.25M16.625 23.625V17.5C16.625 17.2679 16.5328 17.0454 16.3687 16.8813C16.2046 16.7172 15.9821 16.625 15.75 16.625H12.25C12.0179 16.625 11.7954 16.7172 11.6313 16.8813C11.4672 17.0454 11.375 17.2679 11.375 17.5V23.625" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <span class="custom-option-title">Residential</span>
                    </span>
                    <input name="type" class="form-check-input" type="radio" value="resident" id="customRadioHome" checked />
                  </label>
                </div>
              </div>
              <div class="col-md mb-md-0 mb-4">
                <div class="form-check custom-option custom-option-icon">
                  <label class="form-check-label custom-option-content" for="customRadioOffice">
                    <span class="custom-option-body">
                      <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.2" d="M15.75 23.625V4.375C15.75 4.14294 15.6578 3.92038 15.4937 3.75628C15.3296 3.59219 15.1071 3.5 14.875 3.5H4.375C4.14294 3.5 3.92038 3.59219 3.75628 3.75628C3.59219 3.92038 3.5 4.14294 3.5 4.375V23.625" />
                        <path d="M1.75 23.625H26.25M15.75 23.625V4.375C15.75 4.14294 15.6578 3.92038 15.4937 3.75628C15.3296 3.59219 15.1071 3.5 14.875 3.5H4.375C4.14294 3.5 3.92038 3.59219 3.75628 3.75628C3.59219 3.92038 3.5 4.14294 3.5 4.375V23.625M24.5 23.625V11.375C24.5 11.1429 24.4078 10.9204 24.2437 10.7563C24.0796 10.5922 23.8571 10.5 23.625 10.5H15.75M7 7.875H10.5M8.75 14.875H12.25M7 19.25H10.5M19.25 19.25H21M19.25 14.875H21" stroke-opacity="0.9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <span class="custom-option-title">Office</span>
                    </span>
                    <input name="type" class="form-check-input" type="radio" value="office" id="customRadioOffice" />
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label" for="companyName">Company Name</label>
            <input type="text" id="companyName" name="companyName" class="form-control" placeholder="St. Odumo" readonly />
          </div>
          <input type="text" id="beatid" name="beat_id" class="form-control" readonly hidden/>
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
