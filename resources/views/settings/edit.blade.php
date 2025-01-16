@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Edit Setting</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <form action="{{ route('settings.update', ['setting' => encrypt($setting->id)]) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Add method spoofing for PUT request -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keySetting" class="form-label">Key</label>
                                        <input type="text" class="form-control" id="keySetting" name="key"
                                            value="{{ $setting->key }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valueSetting" class="form-label">Value</label>
                                        <input type="text" class="form-control" id="valueSetting" name="value"
                                            value="{{ $setting->value }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Modal trigger button -->
                            <div class="d-flex justify-content-end">
                                <!-- Use a regular submit button, instead of <a> -->
                                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0">
                                    Edit Setting
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.cabang.modal-add')
@endsection
@push('styles')
    <style>
        .btn-icon {
            padding: 6px 15px;
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('#tabelcabang').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            });
        });
    </script>
@endpush
