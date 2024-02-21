@extends('layouts.app')

@section('title', 'Test Laravel | Mahasiswa')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Lomba</h4>

                            <div class="align-right text-right">

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                                    Tambah Mahasiswa
                                </button>
                            </div>
                            <br>
                            <div class="search-element">
                                <input id="searchInput" class="form-control" type="search" placeholder="Search"
                                    aria-label="Search">
                            </div>

                            <br>

                            <div class="table-responsive">
                                <table id="example" class="table table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Jenis Kelamin</th>
                                            <th class="text-center">Alamat</th>
                                            <th class="text-center">KRS</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mahasiswas as $no => $mahasiswa)
                                            <tr>
                                                <td class="text-center">{{ ++$no }}</td>
                                                <td class="text-center">{{ $mahasiswa->nama }}</td>
                                                <td class="text-center">{{ $mahasiswa->jenis_kelamin }}</td>
                                                <td class="text-center">{{ $mahasiswa->alamat }}</td>
                                                <td class="text-center">
                                                    <a href="{{ asset($mahasiswa->krs) }}" class="btn btn-primary"
                                                        download>Download KRS</a>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button data-toggle="modal"
                                                        data-target="#editUserModal{{ $mahasiswa->id }}" type="button"
                                                        class="btn btn-info">Edit</button>

                                                    <!-- SweetAlert untuk konfirmasi penghapusan -->
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="confirmDelete('{{ $mahasiswa->id }}')">Delete</button>

                                                    <!-- Form untuk menghapus -->
                                                    <form id="deleteForm-{{ $mahasiswa->id }}" method="post"
                                                        action="{{ route('mahasiswa.destroy', $mahasiswa->id) }}"
                                                        style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tambah Pengguna Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Lomba</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" id="laki-laki" name="jenis_kelamin"
                                            value="Laki-laki" required>
                                        <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="perempuan" name="jenis_kelamin"
                                            value="Perempuan" required>
                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tabel">Data Tambahan</label>
                                <table class="table" id="tabelTambahan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Matakuliah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="btnTambah">Tambah</button>
                            </div>
                            <div class="mb-3">
                                <label for="krs" class="form-label">Kartu Rencana Studi (KRS,pdf only)</label>
                                <input type="file" class="form-control" id="krs" name="krs" required
                                    accept=".pdf">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @foreach ($mahasiswas as $mahasiswa)
            <!-- Modal Edit Mahasiswa -->
            <div class="modal fade" id="editUserModal{{ $mahasiswa->id }}" tabindex="-1"
                aria-labelledby="editUserModalLabel{{ $mahasiswa->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel{{ $mahasiswa->id }}">Edit Mahasiswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $mahasiswa->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <div class="d-flex">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio"
                                                id="laki-laki{{ $mahasiswa->id }}" name="jenis_kelamin"
                                                value="Laki-laki"
                                                {{ $mahasiswa->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }} required>
                                            <label class="form-check-label"
                                                for="laki-laki{{ $mahasiswa->id }}">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                id="perempuan{{ $mahasiswa->id }}" name="jenis_kelamin"
                                                value="Perempuan"
                                                {{ $mahasiswa->jenis_kelamin == 'Perempuan' ? 'checked' : '' }} required>
                                            <label class="form-check-label"
                                                for="perempuan{{ $mahasiswa->id }}">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required>{{ $mahasiswa->alamat }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="krs" class="form-label">Kartu Rencana Studi (KRS, pdf only)</label>
                                    <input type="file" class="form-control" id="krs" name="krs"
                                        accept=".pdf">
                                    @if ($mahasiswa->krs)
                                        <p class="text-muted mt-2">KRS Saat Ini: <a href="{{ asset($mahasiswa->krs) }}"
                                                target="_blank">{{ basename($mahasiswa->krs) }}</a></p>
                                    @else
                                        <p class="text-muted mt-2">Tidak ada KRS yang diunggah.</p>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="tabel">Data Tambahan</label>
                                    <table class="table" id="tabelTambahan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Matakuliah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mahasiswa->mataKuliahs as $index => $data)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><input type="text" class="form-control"
                                                            name="nama_matakuliah[]" value="{{ $data->nama_matakuliah }}"
                                                            required></td>
                                                    <td><button type="button"
                                                            class="btn btn-danger btn-sm btnHapus">Hapus</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" id="btnTambah">Tambah</button>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            $(document).ready(function() {
                // Fungsi untuk menambahkan baris baru ke dalam tabel tambahan
                $('#btnTambah').click(function() {
                    var nomor = $('#tabelTambahan tbody tr').length + 1;
                    var newRow = '<tr>' +
                        '<td class="nomor">' + nomor + '</td>' +
                        '<td><input type="text" class="form-control" name="nama_matakuliah[]"></td>' +
                        '<td><button type="button" class="btn btn-danger btn-sm btnHapus">Hapus</button></td>' +
                        '</tr>';
                    $('#tabelTambahan tbody').append(newRow);
                });

                // Fungsi untuk menghapus baris dari tabel tambahan
                $(document).on('click', '.btnHapus', function() {
                    $(this).closest('tr').remove();
                    updateNomor();
                });

                // Fungsi untuk memperbarui nomor urutan setelah baris dihapus
                function updateNomor() {
                    $('#tabelTambahan tbody tr').each(function(index) {
                        $(this).find('.nomor').text(index);
                    });
                }


                $('form').submit(function() {
                    var dataTambahan = [];
                    $('#tabelTambahan tbody tr').each(function() {
                        var namaMatakuliah = $(this).find('input[name="nama_matakuliah[]"]').val();
                        dataTambahan.push({
                            nama_matakuliah: namaMatakuliah
                        });
                    });

                    $('<input />').attr('type', 'hidden')
                        .attr('name', 'data_tambahan')
                        .attr('value', JSON.stringify(dataTambahan))
                        .appendTo('form');
                    return true;
                });
            });
        </script>
        @if (session('notification'))
            <script>
                $(document).ready(function() {
                    const {
                        title,
                        text,
                        type
                    } = @json(session('notification'));
                    Swal.fire(title, text, type);
                });
            </script>
        @endif
        <script>
            $(document).ready(function() {
                $('#createModal').on('hidden.bs.modal', function() {
                    $(this).find('form')[0].reset();
                });
            });
        </script>
        <script>
            function confirmDelete(mahasiswaId) {
                swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data mahasiswa akan dihapus secara permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form penghapusan jika pengguna mengonfirmasi
                        document.getElementById('deleteForm-' + mahasiswaId).submit();
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                // Fungsi untuk melakukan pencarian
                function searchTable(value) {
                    $('table tbody tr').each(function() {
                        var nama = $(this).find('td:eq(1)').text().toLowerCase();
                        var jenis_kelamin = $(this).find('td:eq(2)').text()
                            .toLowerCase();
                        var alamat = $(this).find('td:eq(3)').text().toLowerCase();
                        var match = (nama.indexOf(value) > -1 || jenis_kelamin.indexOf(value) > -1 || alamat
                            .indexOf(value) > -1);
                        $(this).toggle(match);
                    });
                }
                $('#searchInput').on('input', function() {
                    var value = $(this).val().toLowerCase().trim();
                    if (value === "") {
                        $('table tbody tr').show();
                    } else {
                        searchTable(value);
                    }
                });
            });
        </script>

    @endsection
