<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Parkir Fasilkom Unej</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://s3-us-west-2.amazonaws.com/s.cdpn.io/4579/bootstrap-table.css'>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .modal-content {
            max-width: 400px;
            /* Atur lebar maksimal */
            margin: 30 auto;
            /* Pusatkan di tengah */
            padding: 20px;
            background-color: #f1f1f1;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .yes-button,
        .no-button {
            padding: 15px 30px;
            font-size: 14px;
            border-radius: 15px;
            margin: 0 50px;
            /* Tambahkan margin horizontal */
        }

        .yes-button {
            background-color: #4CAF50;
            color: white;
        }

        .no-button {
            background-color: #f44336;
            color: white;
        }

        /* button hapus */
        .btn {
            border-radius: 10px;
            /* Tambahkan sudut melengkung */
        }

        .btn-danger {
            /* Ganti warna latar belakang dan warna teks tombol sesuai kebutuhan */
            background-color: #f44336;
            color: white;
        }

        .btn-sm {
            /* Atur ukuran font dan padding tombol sesuai kebutuhan */
            font-size: 14px;
            padding: 5px 10px;
        }

        th {
            text-align: center;
        }

        tr {
            text-align: center;
        }

        #tombolTambah {
            margin-bottom: 10px;
        }

        .alert {
            margin-bottom: 10px;
        }


        /* tambah data */
        .form-input {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border-radius: 10px;
        }

        .form-container {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>

    <!-- partial:index.partial.html -->

    <body>

        <div id='wrapper'>
            <nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
                <div class='navbar-header'>
                    <button type='button' class='navbar-toggle' data-toggle='collapse'
                        data-target='.navbar-hamburger-delicious'>
                        <span class='sr-only'>Toggle navigation</span>
                        <span class='icon-bar'></span>
                        <span class='icon-bar'></span>
                        <span class='icon-bar'></span>
                    </button>
                    <a class='navbar-brand'>Pengelolaan Data Mahasiswa</a>
                </div>

                <div class='collapse navbar-collapse navbar-hamburger-delicious'>
                    <ul class='nav navbar-nav side-nav fadeInLeft'>
                        <li class='toggle-nav visible-lg visible-md visible-sm'><a href="{{ route('dashboard') }}"><i
                                    class='fa fa-lg fa-arrow-left'></i>Dashboard</a></li>
                        {{-- <li class='dashboard'><a href='#'><i class='fa fa-lg fa-dashboard'></i>Dash</a></li> --}}
                        <li class='active docs'><a href='#docs'><i class='fa fa-lg fa-user'></i>Data Mahasiswa</a>
                        </li>
                        <li class='admin'><a href='{{ route('logout') }}'><i
                                    class='fas fa-sign-out-alt fa-lg'></i>Logout</a></li>
                        <li class='divider'>
                            <hr>
                        </li>

                    </ul>
                    <ul class='nav navbar-nav navbar-right navbar-user'>
                        <li class='dropdown user-dropdown'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class="js-user-name">
                                    @if (Auth::guard('admin')->user()->foto)
                                        <img src="{{ asset('storage/' . old('foto', Auth::guard('admin')->user()->foto)) }}"
                                            alt="Admin" class="rounded-circle p-1 border border-warning"
                                            id="image-preview" width="45" height="45">
                                    @else
                                        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw8ODg0ODQ8NDQ0NDQ0NDg0NDQ8NDQ0NFREWFhURFRUYHSggGBolGxUVITEhJTUrLi4uFx8zODMsNygtLisBCgoKBQUFDgUFDisZExkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIALQAtAMBIgACEQEDEQH/xAAaAAEAAwEBAQAAAAAAAAAAAAAAAQMEBQIH/8QALRAAAgEDAwMEAgICAwEAAAAAAAECAwQRITFREkFhcYGRobHRIlIy8ULB8BT/xAAUAQEAAAAAAAAAAAAAAAAAAAAA/8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEQMRAD8A+4gACCSAAJIZmrXSWkdXz2A0yaW7x6med3FbZf0jHOblq3k8gaJXcnthFTqye8n8ngAS2CAB6Umtm17nuNxNd8+upUANcLz+y+DRTrRls9eHozmADrg59K5lHfVedzZSqqW3x3AsBAAkgAASQSBABIEETmorL0QnNRWX2OdWquTy9uy4A9V67l4XH7KQAAAAAAAAAAAAAAATFtarRkADdb3HVpLR/TNByTba3Gf4y37PkDSAABIAEDJJlvKuF0rd7+gFFxW6n4W37KQAAAAAHqnByaS7gKcHJ4SNlO0S/wAtX9F1KmorC/2ewPMYJbJL0RJJAFc6EX291oZa1s46rVfaN5AHJBru6GP5L3X/AGZAAAAEpkADo21bqWu63/ZacylPpaa/8jpxllJruBIAAiTwm321OXOXU233Nl7PEccv6MIAAAAAAN1lTwuru/wYTq01iKXCQHoAACCSAJAIANZOZVh0ya4f0dQw3y/knygMwAAAAAbLKpvHjVehjPdGfTJPz9AdQAAYLyWZY4RQeqzzKT8s8AAAAAAA60dl6HJOlbSzBeNALSAAJIAAkgACTHf7x9GbDnXcsyfjQCkAAAAAAAHToSzGL8EFVpPEcPlkAZGQSQAAAAAAC+1q9Lw9n9MoAHWBjt7nGktuz4NiedtQAJIAAkqrV1Hy+AFer0ry9jnM9VKjk8v/AEeAAAAAAAAAPcZ4IIAEzWG1w2eS25jicvOpUAAAAAAD1GLeiWWWUKDlrsuTdCCisJYAyK0lyl4PDU6fK/DOgAMUbyXdJ/RLvH/VfJolbwfZe2h5VrDj7YGaVxOWm3hEwtZPV6eu5thBLZJEgc6pbyj2yuUVHXM9e2T1jo/pgYAS1jR7kAAAAAAF9CnlZ8kmi0jiC85ZIFN9HZ+xkOnXh1Ra77r1OYAAAAut6XU/C3/RUdKjT6YpfPqB7SxotiSCQAIAEgEASAQBIAAouaPUsr/JfZzzrmC8p4eVs/yBnAAAlLOnJBos4ZlntHX3A2xjhJcLAPQAgwXVPplns9fc3nitT6k18eoHMBMlh4e6IAvtIZmvGp0Dn21VReuz78G/IAkAAQSABBIAAAAAABVcwzF+NS0puKyiuW9kBzgAAOlb0+mK5erM1pSy+p7LbyzcAAAEAADPdUOrVbr7RhOsZrm3zrHfuuQMRdQruOm8eOCpkAdSE1JZTyezlRk08ptGqnef2XugNQPMKkZbNP8AJ6AAkgCQCGwJBRUuYry/Blq3EpeFwgNNe5S0jq/pGGTbeXqyAALaFJyfjuxRouT8d2dCnBRWEBMYpLC2RIAAAAQSQABJBIFNe3UtdnyYalNx3X6OoRKKej1QHJBsqWn9Xjw9jNOlKO69+wHg9xrSW0meABerqfK+EP8A65+PgoAFruJv/l8JIrlJvdt+pAAAlLO2pfTtZPf+K87gZzTRtW9ZaLjuzTSoRjtq+WWgRGKSwtESAAAAAAAAABBIAAAAAABXKjF7pfgpqWsVtn5AAyzjg8gAXUqKe+TTG1gu2fVkgCyMUtkl6HoACASAIBIAAAAAAP/Z"
                                            alt="Admin" class="rounded-circle p-1 border border-warning"
                                            id="image-preview" width="45" height="45">
                                    @endif Hallo
                                    {{ Auth::guard('admin')->user()->username }}
                                </span><b class='caret'></b></a>
                            <ul class="dropdown-menu">
                                <li class="settings">
                                    <div>
                                        <form action="{{ route('updateFoto') }}" method="post"
                                            enctype="multipart/form-data">
                                            @method('PATCH')
                                            @csrf
                                            <label for="foto" class="fotoku">
                                                <input id="foto" name="foto" type="file" class="file"
                                                    onchange="previewImage()">
                                            </label>
                                            @error('foto')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="submit" class="btn btn-primary px-4" value="Save">
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </nav>

            <div id='page-wrapper'>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h2>Mahasiswa {{ $mahasiswa->name }}</h2>
                            {{-- @foreach ($matkul as $item)
                                <h2>{{ $item-> }}</h2>
                            @endforeach --}}
                            <hr />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 js-content">
                            <div class="docs-table">
                                <button class="btn btn-primary btn-lg" id="tombolTambah">Input Nilai</button>
                                {{-- <button id="tombolCek">cek</button> --}}

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Tampilan Pesan Error -->
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('matkul_exists'))
                                    <div class="alert alert-danger">
                                        Nilai Mata Kuliah Sudah Ada!
                                    </div>
                                @endif


                                <table data-toggle="table" data-show-toggle="true" data-show-columns="true"
                                    data-search="true" data-striped="true">
                                    <thead>
                                        <tr>
                                            <th data-field="No">No</th>
                                            <th data-field="Mata Kuliah">Mata Kuliah</th>
                                            <th data-field="Nilai">Nilai</th>
                                            <th data-field="Grade">Grade</th>
                                            <th data-field="Aktivitas">Aktivitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nilai as $key => $item)
                                            {{-- <tr id="row-{{ $item->id }}"> --}}
                                            <tr>
                                                <td>{{ $nilai->firstItem() + $key }}</td>
                                                <td>{{ $item->matkul->matkul }}</td>
                                                <td>{{ $item->nilai }}</td>
                                                <td>{{ $item->grade }}</td>
                                                <td>
                                                    {{-- <div
                                                        style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                                        <button class="btn btn-success btn-sm"
                                                            onclick="showEditModal('{{ $item->id }}')">Edit</button>

                                                    </div> --}}
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="showModal('{{ $item->id }}')">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div id="modalCek-{{ $item->id }}" class="modal">
                                                <div class="modal-content">
                                                    <span class="close"
                                                        onclick="hideModal('{{ $item->id }}')">&times;</span>
                                                    <h2>Konfirmasi</h2>
                                                    <p>Apakah Anda yakin ingin menghapus data mahasiswa ini?</p>
                                                    <div class="button-container">
                                                        <button class="yes-button"
                                                            onclick="window.location.href='{{ route('deleteNilai', $item->id) }}'">Iya</button>
                                                        <button class="no-button"
                                                            onclick="hideModal('{{ $item->id }}')">Tidak</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $nilai->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal1()">&times;</span>
            <form action="{{ route('inputData', ['id' => $mahasiswa->id]) }}" method="POST" class="form-container">
                @csrf
                <div class="form-group">
                    <label for="matkul">Mata Kuliah:</label>
                    <select id="matkul" name="matkul" required class="form-input rounded">
                        <option disabled value>Pilih Mata Kuliah</option>
                        @foreach ($matkul as $item)
                            <option value="{{ $item->id }}">{{ $item->matkul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nilai">Nilai</label>
                    <input type="number" id="nilai" name="nilai" placeholder="Masukkan Nilai Mahasiswa"
                        required class="form-input rounded">
                </div>
                <div class="button-container">
                    <input class="btn btn-primary btn-lg rounded" type="submit" value="Simpan">
                </div>
            </form>
        </div>
    </div>

    <!-- partial -->
    <script>
        var tombolTambah = document.getElementById("tombolTambah");
        var modal = document.getElementById("modalTambah");
        var formElement = document.getElementById("formElement");
        var closeButton = document.getElementsByClassName("close")[0];
        // Saat tombol "Tambah" ditekan, tampilkan modal
        tombolTambah.onclick = function() {
            modal.style.display = "block";
        }
        formElement.action = "{{ route('storeMahasiswa') }}"
        // Saat tombol "Tutup" atau area di luar modal ditekan, sembunyikan modal
        closeButton.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function hideModal1() {
            modal.style.display = "none";
        }

        function showModal(itemId) {
            var modal = document.getElementById('modalCek-' + itemId);
            modal.style.display = 'block';
        }

        function hideModal(itemId) {
            var modal = document.getElementById('modalCek-' + itemId);
            modal.style.display = 'none';
        }

        function hapusData(itemId) {
            // Perform delete operation based on the itemId
            console.log('Delete data with ID: ' + itemId);
            // You can send an AJAX request to the server to delete data or use a method appropriate for your application
            hideModal(itemId); // Hide the modal after deleting the data
        }

        var editModal = document.getElementById("editModal");
        var editFormElement = document.getElementById("editFormElement");
        var editCloseButton = document.getElementsByClassName("edit-close")[0];

        // Saat tombol "Tutup" pada modal edit ditekan, sembunyikan modal edit
        editCloseButton.onclick = function() {
            editModal.style.display = "none";
        }

        function hideEditModal() {
            editModal.style.display = "none";
        }

        function showEditModal(itemId) {
            var modal = document.getElementById('editModal');
            modal.style.display = 'block';

            // Set form action for edit form
            var editForm = document.getElementById('editForm');
            editForm.action = "{{ route('updateMahasiswa', '') }}/" + itemId;

            // Populate form fields with data for editing
            var row = document.getElementById("row-" + itemId);
            var nim = row.cells[1].innerText;
            var name = row.cells[2].innerText;
            var prodi = row.cells[3].innerText;
            var noHp = row.cells[4].innerText;

            // Set form field values
            document.getElementById("editNim").value = nim;
            document.getElementById("editName").value = name;
            document.getElementById("editProdi").value = prodi;
            document.getElementById("editNoHp").value = noHp;
        }

        function previewImage() {
            const foto = document.querySelector('#foto');
            const imgPreview = document.querySelector('#image-preview');
            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/4579/bootstrap.min.js'></script>
    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/4579/bootstrap-table.js'></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
