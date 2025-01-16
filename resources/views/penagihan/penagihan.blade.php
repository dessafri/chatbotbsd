@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Data Penagihan') }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <!-- Form for importing Excel -->
                        <button class="btn btn-primary mx-2 button-margin-15" id="startChatbot">
                            Jalankan Chatbot
                        </button>

                        <!-- Link to upload invoice -->
                        <a href="{{ route('penagihan.faktur') }}">
                            <button class="btn btn-info mx-2 button-margin-15">
                                Upload Bukti Faktur
                            </button>
                        </a>
                        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex align-items-center">
                            @csrf
                            <div class="form-group mb-0">
                                <input type="file" name="file" id="fileInput" class="form-control" required
                                    style="width: auto; margin-right: 10px;">
                            </div>
                            <button type="submit" class="btn btn-success mx-2 button-margin-15">
                                Import Excel
                            </button>
                        </form>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="tabelpenagihan">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Customer</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nomor Handphone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Piutang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nilai Faktur</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Pembayaran</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nomor Faktur</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode Cabang</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($penagihans)
                                    @foreach ($penagihans as $key => $penagihan)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 text-center">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                @if ($penagihan->status == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Terkirim</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Belum Terkirim</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nama_customer }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nomor_handphone }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nilai_faktur }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->piutang }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->pembayaran }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nomorfaktur }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->kode_cabang }}</p>
                                            </td>
                                            <td class="text-start align-middle">
                                                <div class="d-flex justify-content-center align-items-center pt-3">
                                                    <!-- Update Button -->
                                                    @if ($penagihan->status === 1)
                                                        <a href="{{ route('penagihan.edit', ['penagihan' => encrypt($penagihan->id)]) }}"
                                                            class="btn btn-info btn-icon me-1"
                                                            id="edit-{{ encrypt($penagihan->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('penagihan.edit', ['penagihan' => encrypt($penagihan->id)]) }}"
                                                            class="btn btn-info btn-icon me-1"
                                                            id="edit-{{ encrypt($penagihan->id) }}">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </a>
                                                    @endif
                                                    <!-- Destroy Button -->
                                                    <form
                                                        action="{{ route('penagihan.destroy', ['penagihan' => encrypt($penagihan->id)]) }}"
                                                        method="POST" id="delete-form-{{ encrypt($penagihan->id) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-icon"
                                                            id="delete-{{ $penagihan->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12" class="text-center">Data Tidak Ditemukan</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-icon {
            padding: 6px 15px;
        }

        .button-margin-15 {
            margin-top: 12px !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#tabelpenagihan').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            });

            // Event listener untuk tombol #startChatbot
            document.getElementById('startChatbot').addEventListener('click', function(e) {
                e.preventDefault();
                const apiToken = '{{ env('API_TOKEN') }}';
                const urlChatbot = '{{ env('URL_CHATBOT') }}';
                fetch('{{ url('/setting/status-chatbot') }}')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        if (data.statusCode === 200) {
                            // Jika layanan chatbot aktif
                            Swal.fire({
                                title: 'Apakah Anda Yakin Menjalankan Chatbot?',
                                showCancelButton: true,
                                confirmButtonText: 'Jalankan',
                                cancelButtonText: 'Batalkan',
                                showLoaderOnConfirm: false, // Tidak perlu loader karena tidak ada async
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Make a fetch request to get customer data
                                    fetch('{{ url('/api/get-customer') }}', {
                                            method: 'GET',
                                            headers: {
                                                'Authorization': 'Bearer ' +
                                                    apiToken, // Use the token here
                                                'Content-Type': 'application/json', // Specify content type
                                            }
                                        })
                                        .then(response => {
                                            console.log(
                                                response
                                            ); // Log the response object to inspect its content
                                            return response
                                                .text(); // Get the response as text first to check if it's HTML
                                        })
                                        .then(text => {
                                            console.log(
                                                text
                                            ); // Log the text response to see what was returned
                                            try {
                                                const data = JSON.parse(
                                                    text
                                                ); // Try to parse the text into JSON
                                                data.data.forEach(row => {
                                                    console.log(row)
                                                    const dearText = row.dear_text;
                                                    const namaCustomer = row.name;
                                                    const fakturData = row.faktur
                                                    const totalTagihan = row
                                                        .total_faktur;
                                                    if (!Array.isArray(
                                                            fakturData)) {
                                                        return;
                                                    }

                                                    // Get current hour for greeting
                                                    const hour = new Date()
                                                        .getHours();
                                                    let salam = '';
                                                    if (hour >= 4 && hour < 12) {
                                                        salam = "Selamat Pagi";
                                                    } else if (hour >= 12 && hour <
                                                        15) {
                                                        salam = "Selamat Siang";
                                                    } else if (hour >= 15 && hour <
                                                        18) {
                                                        salam = "Selamat Sore";
                                                    } else {
                                                        salam = "Selamat Malam";
                                                    }

                                                    // Build the WhatsApp message text
                                                    let textWa =
                                                        `Yth ${dearText} ${namaCustomer}, ${salam}. Kami dari ${row.nama_cabang} menginformasikan Tagihan Faktur sbb:\n\n`;

                                                    let fakturCounter = 1;
                                                    fakturData.forEach(faktur => {
                                                        const noFaktur =
                                                            faktur[
                                                                'No Faktur'
                                                            ];
                                                        const nilaiFaktur =
                                                            faktur[
                                                                'nilai_faktur'
                                                            ];
                                                        const tglFaktur =
                                                            faktur[
                                                                'tgl_faktur'
                                                            ];

                                                        // Calculate the due date (30 days from invoice date)
                                                        const tglFakturObj =
                                                            new Date(
                                                                tglFaktur);
                                                        tglFakturObj
                                                            .setDate(
                                                                tglFakturObj
                                                                .getDate() +
                                                                30
                                                            ); // Add 30 days
                                                        const
                                                            tglJatuhTempo =
                                                            tglFakturObj
                                                            .toLocaleDateString(
                                                                'id-ID', {
                                                                    day: '2-digit',
                                                                    month: 'short',
                                                                    year: 'numeric'
                                                                });

                                                        // Add invoice details to the message
                                                        textWa +=
                                                            `No Faktur ${fakturCounter}: ${noFaktur}\n`;
                                                        textWa +=
                                                            `Nilai Tagihan ${fakturCounter}: Rp ${nilaiFaktur.toLocaleString()}\n`;
                                                        textWa +=
                                                            `Jatuh Tempo ${fakturCounter}: ${tglJatuhTempo}\n\n`;
                                                        fakturCounter++;
                                                    });

                                                    // Add total amount to the message
                                                    textWa +=
                                                        `Total Tagihan: Rp ${totalTagihan.toLocaleString()}\n\n`;

                                                    textWa += `Pembayaran bisa melalui transfer rekening ${row.kode_bank} ${row.nomor_rekening} a/n. ${row.nama_rekening}, dan utk memudahkan proses tracking serta menghindari penagihan kembali mohon pd saat transfer diberi keterangan Nama_Klinik_Merek_Nomor Faktur.
                                                                \nApabila sudah ditransfer mohon dapat di informasikan ke nomor ini juga.
                                                                \nTerimakasih atas kerjasama dan kepercayaannya kepada kami.
                                                                \nSemoga ${dearText} ${namaCustomer} sehat selalu`;

                                                    // Prepare the message to send via API
                                                    const postParameter = {
                                                        message: textWa
                                                    };

                                                    const id = row.kode_order;
                                                    const phoneNumber = row
                                                        .nomor_handphone;

                                                    // Send the message using a POST request
                                                    fetch(`${urlChatbot}/chat/sendmessage/${phoneNumber}`, {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json'
                                                            },
                                                            body: JSON
                                                                .stringify(
                                                                    postParameter
                                                                )
                                                        })
                                                        .then(response => response
                                                            .json())
                                                        .then(responseData => {
                                                            // Check the response for success (adjust based on API response)
                                                            if (responseData
                                                                .status ===
                                                                'success') {
                                                                const
                                                                    csrfToken =
                                                                    document
                                                                    .querySelector(
                                                                        'meta[name="csrf-token"]'
                                                                    )
                                                                    .getAttribute(
                                                                        'content'
                                                                    );
                                                                console.log(
                                                                    csrfToken
                                                                );
                                                                // Update the status if no errors
                                                                fetch(`${urlRoot}/update-status/${id}`, {
                                                                        method: 'POST',
                                                                        body: JSON
                                                                            .stringify({
                                                                                status: 1,
                                                                                waktu_kirim: new Date()
                                                                                    .toISOString()
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
                                                                                    text: 'Chatbot Berhasil Terkirim',
                                                                                    icon: 'success',
                                                                                    showConfirmButton: false, // Hide the confirm button
                                                                                    timer: 3000 // Close after 3 seconds
                                                                                });

                                                                                // Trigger page reload after 3 seconds (to allow the notification to show)
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
                                                        })
                                                        .catch(error => {
                                                            console.error(
                                                                'Error sending message:',
                                                                error);
                                                        });
                                                });
                                            } catch (error) {
                                                console.error('Error parsing JSON:',
                                                    error); // Log any JSON parsing errors
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error fetching data:',
                                                error); // Handle fetch errors
                                        });

                                } else {
                                    console.log('Aksi dibatalkan.'); // Action was canceled
                                }

                            });

                        } else {
                            // Jika layanan chatbot tidak aktif
                            Swal.fire(
                                'Gagal!',
                                'Chatbot service tidak aktif.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        // Jika terjadi error saat memeriksa status layanan chatbot
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan dalam memeriksa status Chatbot.',
                            'error'
                        );
                        console.error('Error checking chatbot status:', error);
                    });
            });
        });
    </script>
@endpush
