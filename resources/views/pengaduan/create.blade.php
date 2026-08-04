<h1>Form Pengaduan Masyarakat</h1>

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama</label>
    <input type="text" name="nama" value="{{ old('nama') }}">
    <br>

    <label>Email (opsional)</label>
    <input type="email" name="email" value="{{ old('email') }}">
    <br>

    <label>Telepon (opsional)</label>
    <input type="text" name="telepon" value="{{ old('telepon') }}">
    <br>

    <label>Kategori</label>
    <select name="kategori">
        <option value="sarana_prasarana">Sarana Prasarana</option>
        <option value="kepegawaian">Kepegawaian</option>
        <option value="pelayanan">Pelayanan</option>
        <option value="lainnya">Lainnya</option>
    </select>
    <br>

    <label>Judul</label>
    <input type="text" name="judul" value="{{ old('judul') }}">
    <br>

    <label>Isi Pengaduan</label>
    <textarea name="isi">{{ old('isi') }}</textarea>
    <br>

    <label>Lampiran (maks. 3 file, jpg/png/pdf)</label>
    <input type="file" name="lampiran[]" multiple>
    <br>

    <button type="submit">Kirim Pengaduan</button>
</form>