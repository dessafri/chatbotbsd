@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Semua Setting</h5>
                            </div>
                            <div class="d-flex justify-content-start">
                                <!-- Check Chatbot Button -->
                                <button class="btn btn-warning mx-2 button-margin-15" id="checkChatbot">
                                    Check Chatbot
                                </button>

                                <!-- Stop Chatbot Button -->
                                <button class="btn btn-danger mx-2 button-margin-15" id="refreshQR">
                                    Refresh QRCode
                                </button>

                                <!-- Restart Chatbot Button -->
                                <button class="btn btn-warning mx-2 button-margin-15" id="restartChatbot">
                                    Restart Chatbot
                                </button>

                                <!-- Reset Chatbot Button -->
                                <button class="btn btn-secondary mx-2 button-margin-15" id="resetChatbot">
                                    Reset Chatbot
                                </button>
                                <button class="btn bg-gradient-primary mx-2 button-margin-15" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop" id="resetChatbot">
                                    Tambah Setting
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <div class="row">
                            <!-- Kolom untuk Data Setting -->
                            <div class="col-md-12">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0" id="tabelcabang">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No</th>
                                                <th
                                                    class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Key</th>
                                                <th
                                                    class="text-uppercase text-start text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Value</th>
                                                <th
                                                    class="text-uppercase text-start text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($settings)
                                                @foreach ($settings as $key => $setting)
                                                    <tr>
                                                        <td>
                                                            <p class="font-weight-bold mb-0 text-center">{{ $key + 1 }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="font-weight-bold mb-0 text-start">{{ $setting->key }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            @if ($setting->key == 'status_connection_app')
                                                                @if ($setting->value == 'true' || $setting->value == '1')
                                                                    <span
                                                                        class="badge badge-sm bg-gradient-success">Connected</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-sm bg-gradient-danger">Disconnected</span>
                                                                @endif
                                                            @else
                                                                <p class="font-weight-bold mb-0 text-start">
                                                                    {{ $setting->value }}</p>
                                                            @endif
                                                        </td>
                                                        <td class="text-start align-middle">
                                                            <div
                                                                class="d-flex justify-content-center align-items-center pt-3">
                                                                <!-- Update Button -->
                                                                @if ($setting->key !== 'qrcode' && $setting->key !== 'status_connection_app')
                                                                    <a href="{{ route('settings.edit', ['setting' => encrypt($setting->id)]) }}"
                                                                        class="btn btn-info btn-icon me-1"
                                                                        id="edit-{{ encrypt($setting->id) }}">
                                                                        <i class="fa-solid fa-pencil"></i>
                                                                    </a>

                                                                    <!-- Destroy Button -->
                                                                    <form
                                                                        action="{{ route('settings.destroy', ['setting' => encrypt($setting->id)]) }}"
                                                                        method="POST"
                                                                        id="delete-form-{{ encrypt($setting->id) }}"
                                                                        onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-icon"
                                                                            id="delete-{{ $setting->id }}">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                <!-- QR Code Modal Trigger -->
                                                                @if ($setting->key === 'qrcode')
                                                                    <button class="btn btn-primary ms-2 btn-icon"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#qrCodeModal-{{ $setting->id }}">
                                                                        View QR
                                                                    </button>
                                                                    <!-- QR Code Modal -->
                                                                    <div class="modal fade"
                                                                        id="qrCodeModal-{{ $setting->id }}" tabindex="-1"
                                                                        aria-labelledby="qrCodeModalLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <canvas id="qrcode-{{ $setting->id }}"
                                                                                        class="qrcode"></canvas>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Data Tidak Ditemukan</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.setting.modal-add')
@endsection

@push('styles')
    <style>
        .btn-icon {
            padding: 6px 15px;
        }

        .qrcode {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            display: block;
        }

        .table td {
            max-width: 200px;
            /* Adjust the width based on your layout */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelcabang').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            });
            const
                csrfToken =
                document
                .querySelector(
                    'meta[name="csrf-token"]'
                )
                .getAttribute(
                    'content'
                );
            const urlChatbot = '{{ env('URL_CHATBOT') }}';
            $('#checkChatbot').on('click', function() {
                try {
                    fetch(`${urlChatbot}/auth/checkauth`).then(response => response.text())
                        .then(result => {
                            if (result == 'CONNECTED') {
                                if (result === 'CONNECTED') {
                                    console.log(csrfToken)
                                    fetch(`${urlRoot}/update-status-chatbot`, {
                                            method: 'POST',
                                            body: JSON
                                                .stringify({
                                                    value: true,
                                                }),
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken
                                            }
                                        }).then(
                                            response =>
                                            response
                                            .json())
                                        .then(
                                            result => {
                                                if (result
                                                    .statusCode ===
                                                    200
                                                ) {
                                                    Swal.fire({
                                                        title: 'Success',
                                                        text: 'Status Chatbot Connected',
                                                        icon: 'success',
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    });
                                                    setTimeout
                                                        (() => {
                                                                window
                                                                    .location
                                                                    .reload();
                                                            },
                                                            3000
                                                        );
                                                }
                                            })
                                }
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Silahkan Scan Chatbot Terlebih Dahulu',
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                setTimeout
                                    (() => {
                                            window
                                                .location
                                                .reload();
                                        },
                                        3000
                                    );
                            }
                        }).catch(error => {
                            fetch(`${urlRoot}/update-status-chatbot`, {
                                    method: 'POST',
                                    body: JSON
                                        .stringify({
                                            value: false,
                                        }),
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                }).then(
                                    response =>
                                    response
                                    .json())
                                .then(
                                    result => {
                                        if (result
                                            .statusCode ===
                                            200
                                        ) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'Status Chatbot Disconnect',
                                                icon: 'error',
                                                showConfirmButton: false,
                                                timer: 3000
                                            });
                                            setTimeout
                                                (() => {
                                                        window
                                                            .location
                                                            .reload();
                                                    },
                                                    3000
                                                );
                                        }
                                    })
                        });
                } catch (error) {
                    console.log(error)
                }
            })
            $('#restartChatbot').on('click', function() {
                try {
                    fetch(`${urlChatbot}/auth/restart-chatbot`).then(response => response.text())
                        .then(result => {
                            if (result == 'SUCCESS') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Restart Chatbot Successfully',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                setTimeout
                                    (() => {
                                            window
                                                .location
                                                .reload();
                                        },
                                        3000
                                    );
                            }
                            if (result == 'NOTFOUND') {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Service Chatbot Tidak Ada Silahkan Start Manual',
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                setTimeout
                                    (() => {
                                            window
                                                .location
                                                .reload();
                                        },
                                        3000
                                    );
                            }
                        }).catch(error => {
                            fetch(`/update-status-chatbot`, {
                                    method: 'POST',
                                    body: JSON
                                        .stringify({
                                            value: true,
                                        }),
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                }).then(
                                    response =>
                                    response
                                    .json())
                                .then(
                                    result => {
                                        if (result
                                            .statusCode ===
                                            200
                                        ) {
                                            Swal.fire({
                                                title: 'Success',
                                                text: 'Restart Chatbot Successfully',
                                                icon: 'success',
                                                showConfirmButton: false,
                                                timer: 10000
                                            });
                                            setTimeout
                                                (() => {
                                                        window
                                                            .location
                                                            .reload();
                                                    },
                                                    10000
                                                );
                                        }
                                    })

                        });
                } catch (error) {
                    console.log(error)
                }
            })
            $('#resetChatbot').on('click', function() {
                try {
                    fetch(`${urlChatbot}/auth/reset-chatbot`).then(response => response.text())
                        .then(result => {
                            if (result == 'SUCCESS') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Reset Chatbot Successfully',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 7000
                                });
                                setTimeout
                                    (() => {
                                            window
                                                .location
                                                .reload();
                                        },
                                        7000
                                    );
                            }
                            if (result == 'NOTFOUND') {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Service Chatbot Tidak Ada Silahkan Start Manual',
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                setTimeout
                                    (() => {
                                            window
                                                .location
                                                .reload();
                                        },
                                        3000
                                    );
                            }
                        }).catch(error => {
                            Swal.fire({
                                title: 'Success',
                                text: 'Reset Chatbot Successfully',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 7000
                            });
                            setTimeout
                                (() => {
                                        window
                                            .location
                                            .reload();
                                    },
                                    7000
                                );
                        });
                } catch (error) {
                    console.log(error)
                }
            })
            $('#refreshQR').on('click', function() {
                window.location.reload();
            })

            // Generate QR Code for settings with key 'qrcode'
            @if ($settings)
                @foreach ($settings as $setting)
                    @if ($setting->key === 'qrcode')
                        const canvas = document.getElementById('qrcode-{{ $setting->id }}');
                        if (canvas) {
                            QRCode.toCanvas(canvas, '{{ $setting->value }}', {
                                width: 450,
                                height: 450
                            }, function(error) {
                                if (error) console.error('QR Code generation failed:', error);
                                else console.log(
                                    'QR Code for {{ $setting->key }} generated successfully!');
                            });
                        } else {
                            console.error('Invalid canvas element for QR Code:', canvas);
                        }
                    @endif
                @endforeach
            @endif
        });
    </script>
@endpush
