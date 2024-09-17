<!-- Edit User Modal -->
<div class="modal" id="modalGuarantor">
  <div class="modal-dialog modal-lg modal-simple modal-edit-staff">
      <div class="modal-content">
          <div class="modal-body">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="text-center mb-6">
                  <h4 class="mb-2">Add Guarantor Information</h4>
              </div>
              <form action="{{ route('guarantors.store') }}" method="POST" enctype="multipart/form-data" id="guarantorForm" class="row g-6" >
                  @csrf
                  <!-- Guarantor Form Fields -->
                  <input type="text" name="operative_id" value="{{$staff->id}}" hidden>
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
                      <input type="email" id="guarantor_email" name="guarantor_email" class="form-control" value="" />
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
                        <label class="form-label" for="avatarGuarantor">Choose Guarantor Image</label>
                        <input type="file" id="avatarGuarantor" class="form-control" name="avatarGuarantor"
                            accept="image/*" />
                        <br>
                        <img id="imageGuarantorPreview" src="#" height="150" style="display: none;"
                            alt="Guarantor Image Preview">
                        <br>
                        <button type="button" id="deleteGuarantorImageButton" style="display: none;">Delete
                            Image</button>
                    </div>

                    <div class="col-md-6 mb-6">
                        <label class="form-label" for="credentialGuarantor">Choose ID</label>
                        <input type="file" id="credentialGuarantor" class="form-control"
                            name="credentialGuarantor" accept="image/*,.pdf" />
                        <br>
                        <div id="credentialGuarantorPreviewContainer" style="display: none;">
                            <img id="credentialGuarantorPreviewImage" src="#" height="150"
                                style="display: none;" alt="Guarantor ID Preview">
                            <embed id="credentialGuarantorPreviewPDF" src="#" width="100%" height="150"
                                style="display: none;" type="application/pdf">
                        </div>
                        <br>
                        <button type="button" id="deleteGuarantorCredentialButton" style="display: none;">Delete ID
                            File</button>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" id="saveGuarantorBtn" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarGuarantorInput = document.getElementById('avatarGuarantor');
        const imageGuarantorPreview = document.getElementById('imageGuarantorPreview');
        const deleteGuarantorImageButton = document.getElementById('deleteGuarantorImageButton');

        const credentialGuarantorInput = document.getElementById('credentialGuarantor');
        const credentialGuarantorPreviewContainer = document.getElementById(
            'credentialGuarantorPreviewContainer');
        const credentialGuarantorPreviewImage = document.getElementById('credentialGuarantorPreviewImage');
        const credentialGuarantorPreviewPDF = document.getElementById('credentialGuarantorPreviewPDF');
        const deleteGuarantorCredentialButton = document.getElementById('deleteGuarantorCredentialButton');

        const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
        const allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const allowedFileTypes = [...allowedImageTypes, 'application/pdf'];

        function validateFile(file) {
            if (!allowedFileTypes.includes(file.type)) {
                alert("Invalid file type. Only JPEG, PNG, GIF, and PDF are allowed.");
                return false;
            }
            if (file.size > MAX_FILE_SIZE) {
                alert("File size exceeds 2MB. Please choose a smaller file.");
                return false;
            }
            return true;
        }

        avatarGuarantorInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && validateFile(file)) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageGuarantorPreview.src = e.target.result;
                    imageGuarantorPreview.style.display = 'block';
                    deleteGuarantorImageButton.style.display = 'block';
                    avatarGuarantorInput.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                avatarGuarantorInput.value = '';
            }
        });

        deleteGuarantorImageButton.addEventListener('click', function() {
            imageGuarantorPreview.src = '#';
            imageGuarantorPreview.style.display = 'none';
            deleteGuarantorImageButton.style.display = 'none';
            avatarGuarantorInput.style.display = 'block';
            avatarGuarantorInput.value = '';
        });

        credentialGuarantorInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && validateFile(file)) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type === 'application/pdf') {
                        credentialGuarantorPreviewPDF.src = e.target.result;
                        credentialGuarantorPreviewPDF.style.display = 'block';
                        credentialGuarantorPreviewImage.style.display = 'none';
                    } else {
                        credentialGuarantorPreviewImage.src = e.target.result;
                        credentialGuarantorPreviewImage.style.display = 'block';
                        credentialGuarantorPreviewPDF.style.display = 'none';
                    }
                    credentialGuarantorPreviewContainer.style.display = 'block';
                    deleteGuarantorCredentialButton.style.display = 'block';
                    credentialGuarantorInput.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                credentialGuarantorInput.value = '';
            }
        });

        deleteGuarantorCredentialButton.addEventListener('click', function() {
            credentialGuarantorPreviewContainer.style.display = 'none';
            credentialGuarantorPreviewImage.style.display = 'none';
            credentialGuarantorPreviewPDF.style.display = 'none';
            deleteGuarantorCredentialButton.style.display = 'none';
            credentialGuarantorInput.style.display = 'block';
            credentialGuarantorInput.value = '';
        });

        const guarantorForm = document.getElementById('guarantorForm');
        guarantorForm.addEventListener('reset', function() {
            imageGuarantorPreview.style.display = 'none';
            credentialGuarantorPreviewContainer.style.display = 'none';
            deleteGuarantorImageButton.style.display = 'none';
            deleteGuarantorCredentialButton.style.display = 'none';
            avatarGuarantorInput.style.display = 'block';
            credentialGuarantorInput.style.display = 'block';
            avatarGuarantorInput.value = '';
            credentialGuarantorInput.value = '';
        });
    });
</script>
