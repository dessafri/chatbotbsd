@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Upload Bukti Faktur</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <form action="{{ route('upload.bukti.faktur') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="buktiFaktur" class="form-label">Bukti Faktur (Images)</label>
                                        <input type="file" class="form-control" id="buktiFaktur" name="bukti_faktur[]"
                                            accept="image/*" multiple onchange="previewMultipleImages(event)">
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Images -->
                            <div class="row mt-4" id="previewContainer">
                                <!-- Images will be displayed here -->
                            </div>

                            <!-- Modal for Image Preview -->
                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Preview Bukti Faktur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="modalImage" src="" class="img-fluid" alt="Bukti Faktur">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0">
                                    Upload Faktur
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let uploadedImages = []; // Store all uploaded images

        // Function to preview multiple images and add to existing images
        function previewMultipleImages(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('previewContainer');

            Array.from(files).forEach((file) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    uploadedImages.push(e.target.result); // Add image to uploadedImages

                    const colDiv = document.createElement('div');
                    colDiv.classList.add('col-md-3', 'mb-3');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'preview-image');
                    img.style.cursor = 'pointer';
                    img.setAttribute('data-bs-toggle', 'modal');
                    img.setAttribute('data-bs-target', '#imageModal');
                    img.onclick = function() {
                        document.getElementById('modalImage').src = e.target.result;
                    };

                    colDiv.appendChild(img);
                    previewContainer.appendChild(colDiv);
                };

                reader.readAsDataURL(file);
            });
        }

        // Ensure images persist after form submission without server-side logic
        // function handleFormSubmit(event) {
        //     event.preventDefault();
        //     const form = event.target;
        //     const formData = new FormData(form);

        //     // Kirim data dengan Fetch API
        //     fetch(form.action, {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        //             },
        //             body: formData,
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 throw new Error('Gagal mengunggah bukti faktur');
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             alert(data.message);
        //             console.log('Files uploaded:', data.files);
        //         })
        //         .catch(error => {
        //             alert(error.message);
        //             console.error('Error:', error);
        //         });
        // }
    </script>
@endpush
