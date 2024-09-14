<!-- Edit User Modal -->
<div class="modal" id="modalGuarantor">
  <div class="modal-dialog modal-lg modal-simple modal-edit-staff">
      <div class="modal-content">
          <div class="modal-body">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="text-center mb-6">
                  <h4 class="mb-2">Add Guarantor Information</h4>
              </div>
              <form id="guarantorForm"class="row g-6" >
                  {{-- @csrf --}}
                  <!-- Guarantor Form Fields -->
                  <div class="col-12 col-md-4">
                      <label class="form-label" for="guarantor_first_name">First Name</label>
                      <input type="text" id="guarantor_first_name" name="guarantor_first_name" value="" class="form-control" required />
                  </div>
                  <div class="col-12 col-md-4">
                      <label class="form-label" for="guarantor_middle_name">Middle Name</label>
                      <input type="text" id="guarantor_middle_name" name="guarantor_middle_name" value="" class="form-control" />
                  </div>
                  <div class="col-12 col-md-4">
                      <label class="form-label" for="guarantor_last_name">Last Name</label>
                      <input type="text" id="guarantor_last_name" name="guarantor_last_name" value="" class="form-control" required />
                  </div>
                  <div class="col-12 col-md-5">
                      <label class="form-label" for="guarantor_phone_number">Phone Number</label>
                      <div class="input-group">
                          <span class="input-group-text">NG (+234)</span>
                          <input type="text" id="guarantor_phone_number" name="guarantor_phone_number" class="form-control phone-number-mask" placeholder="0802 000 5555" value="" required />
                      </div>
                  </div>
                  <div class="col-12 col-md-3">
                      <label class="form-label" for="guarantor_gender">Gender</label>
                      <select id="guarantor_gender" name="guarantor_gender" class="select2 form-select" aria-label="Gender" required>
                          <option value="female">Female</option>
                          <option value="male">Male</option>
                          <option value="binary">Not Decided</option>
                      </select>
                  </div>
                  <div class="col-12 col-md-4">
                      <label class="form-label" for="guarantor_email">Email</label>
                      <input type="text" id="guarantor_email" name="guarantor_email" class="form-control" value="" />
                  </div>
                  <div class="col-12">
                      <label class="form-label" for="addressGuarantor">Address</label>
                      <input type="text" id="addressGuarantor" name="addressGuarantor" class="form-control" value="" required />
                  </div>
                  <div class="col-6">
                      <label class="form-label" for="areaGuarantor">Area</label>
                      <input type="text" id="areaGuarantor" name="areaGuarantor" class="form-control" value="" required />
                  </div>
                  <div class="col-6">
                      <label class="form-label" for="cityGuarantor">City</label>
                      <input type="text" id="cityGuarantor" name="cityGuarantor" class="form-control" value="" required />
                  </div>

                  <!-- File Uploads -->
                  <div class="col-md-6 mb-6">
                      <label class="form-label" for="guarantor_image">Choose Guarantor Image</label>
                      <input type="file" id="guarantor_image" class="form-control" name="avatarGuarantor" accept="image/*" />
                      <br>
                      <img id="imageGuarantorPreview" src="#" height="150" style="display: none;" alt="Guarantor Image Preview">
                      <br>
                      <button type="button" id="deleteGuarantorImageButton" style="display: none;">Delete Image</button>
                  </div>
                  <div class="col-md-6 mb-6">
                      <label class="form-label" for="guarantor_credential">Choose ID</label>
                      <input type="file" id="guarantor_credential" class="form-control" name="credentialGuarantor" accept="image/*" />
                      <br>
                      <img id="credentialGuarantorPreview" src="#" height="150" style="display: none;" alt="Guarantor ID Preview">
                      <br>
                      <button type="button" id="deleteGuarantorCredentialButton" style="display: none;">Delete ID Image</button>
                  </div>

                  <div class="col-12 text-center">
                      <button type="submit" id="saveGuarantorBtn" class="btn btn-primary">Save</button>
                      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      const guarantorImageInput = document.getElementById('guarantor_image');
      const imageGuarantorPreview = document.getElementById('imageGuarantorPreview');
      const deleteGuarantorImageButton = document.getElementById('deleteGuarantorImageButton');

      const guarantorCredentialInput = document.getElementById('guarantor_credential');
      const credentialGuarantorPreview = document.getElementById('credentialGuarantorPreview');
      const deleteGuarantorCredentialButton = document.getElementById('deleteGuarantorCredentialButton');

      // Function to preview the uploaded guarantor image
      guarantorImageInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  imageGuarantorPreview.src = e.target.result;
                  imageGuarantorPreview.style.display = 'block';
                  deleteGuarantorImageButton.style.display = 'block';
                  guarantorImageInput.style.display = 'none';
              }
              reader.readAsDataURL(file);
          }
      });

      // Function to delete the guarantor image
      deleteGuarantorImageButton.addEventListener('click', function() {
          imageGuarantorPreview.src = '#';
          imageGuarantorPreview.style.display = 'none';
          deleteGuarantorImageButton.style.display = 'none';
          guarantorImageInput.style.display = 'block';
          guarantorImageInput.value = '';
      });

      // Function to preview the uploaded guarantor credential
      guarantorCredentialInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  credentialGuarantorPreview.src = e.target.result;
                  credentialGuarantorPreview.style.display = 'block';
                  deleteGuarantorCredentialButton.style.display = 'block';
                  guarantorCredentialInput.style.display = 'none';
              }
              reader.readAsDataURL(file);
          }
      });

      // Function to delete the guarantor credential
      deleteGuarantorCredentialButton.addEventListener('click', function() {
          credentialGuarantorPreview.src = '#';
          credentialGuarantorPreview.style.display = 'none';
          deleteGuarantorCredentialButton.style.display = 'none';
          guarantorCredentialInput.style.display = 'block';
          guarantorCredentialInput.value = '';
      });
  });
</script>




{{--
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const saveGuarantorBtn = document.getElementById('saveGuarantorBtn');
      const guarantorSuccessMsg = document.getElementById('guarantorSuccessMsg');
      const addGuarantorBtn = document.getElementById('addGuarantorBtn');

      // Handle saving guarantor data from the modal to the hidden fields in the main form
      saveGuarantorBtn.addEventListener('click', function() {
          const guarantorFName = document.getElementById('guarantor_first_name').value;
          const guarantorMName = document.getElementById('guarantor_middle_name').value;
          const guarantorLName = document.getElementById('guarantor_last_name').value;
          const guarantorPhone = document.getElementById('guarantor_phone_number').value;
          const guarantorGender = document.getElementById('guarantor_gender').value;
          const guarantorEmail = document.getElementById('guarantor_email').value;
          const guarantorAddress = document.getElementById('addressGuarantor').value;

          // Set hidden input values in the main form
          document.getElementById('guarantor_fname').value = guarantorFName;
          document.getElementById('guarantor_mname').value = guarantorMName;
          document.getElementById('guarantor_lname').value = guarantorLName;
          document.getElementById('guarantor_phone').value = guarantorPhone;
          document.getElementById('guarantor_address').value = guarantorAddress;



          // Update display section with guarantor information
          document.getElementById('guarantorNameDisplay').innerText = guarantorFName + ' ' + guarantorMName + ' ' + guarantorLName;
          document.getElementById('guarantorPhoneDisplay').innerText = guarantorPhone;
          document.getElementById('guarantorGenderDisplay').innerText = guarantorGender;
          document.getElementById('guarantorEmailDisplay').innerText = guarantorEmail;
          document.getElementById('guarantorAddressDisplay').innerText = guarantorAddress;

          // Show the Guarantor Info section
          document.getElementById('guarantorInfo').style.display = 'block';

          // // Show success message
          // guarantorSuccessMsg.style.display = 'block';

          // // Change the main button text to indicate a guarantor was saved
          // addGuarantorBtn.textContent = 'Guarantor Saved';

          // // Disable the save button after saving
          // saveGuarantorBtn.disabled = true;

          // // Close the modal after saving (with a delay for user feedback)
          // setTimeout(function() {
          //     const modalGuarantor = new bootstrap.Modal(document.getElementById(
          //         'modalGuarantor'));
          //     modalGuarantor.hide();
          //     guarantorSuccessMsg.style.display =
          //     'none'; // Hide the success message after modal closes
          // }, 1000); // Delay of 1 second

          // Show the Guarantor Info section
          document.getElementById('guarantorInfo').style.display = 'block';

          // Close the modal after saving
          const modalGuarantor = new bootstrap.Modal(document.getElementById('modalGuarantor'));
          modalGuarantor.hide();
      });
  });
</script> --}}
