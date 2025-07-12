@extends('layouts.app')

@section('content')
<div class="container px-1 text-main">
    <h1 class="text-main mb-4 text-center">Profil Saya</h1>

        <div class="row justify-content-center">

        {{-- Tampilkan foto profil --}}
        <div class="col-12 col-md-6 mb-4 text-center">
            <img src="{{ asset('storage/foto_profil/' . $user->foto) }}"
            alt="Foto Profil"
            class="img-thumbnail rounded-circle mx-auto"
            style="width: 150px; height: 150px; object-fit: cover;"
            id="foto-profil">
        </div>

        {{-- Form update --}}
        <div class="col-12 col-md-8">
            <div class="overflow-auto">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Modal Crop -->
                    <div id="crop-modal" class="modal" tabindex="-1" style="display:none; position:fixed; z-index:1050; background-color:rgba(0,0,0,0.6); top:0; left:0; width:100%; height:100%; overflow:auto;">
                        <div style="background:white; margin:5% auto; padding:20px; width:90%; max-width:500px; max-height:90vh; overflow:auto;">
                            <h5>Crop Foto</h5>
                            <div>
                                <img id="image-to-crop" style="max-width: 100%;">
                            </div>
                            <div class="mt-2 text-end">
                                <button id="crop-cancel" class="btn btn-secondary btn-sm">Batal</button>
                                <button type="button" id="crop-confirm" class="btn btn-primary btn-sm">Oke</button>
                            </div>
                        </div>
                    </div>



                    {{-- Upload foto baru --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label">Upload Foto Baru</label>
                        <input type="file" id="foto" name="foto" class="form-control" accept="image/*,.heic,.heif" onchange="handleFile(event)">
                    </div>

                    <!-- Hidden Canvas dan input untuk menyimpan hasil crop -->
                    <canvas id="canvas-crop" style="display: none;"></canvas>
                    <input type="hidden" name="cropped_image" id="cropped_image">

                    {{-- Nama --}}
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" id="name" name="name" class="form-control border-left-main" value="{{ old('name', $user->name) }}" required autofocus>
                    </div>

                    {{-- NIK --}}
                    <div class="form-group mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" id="nik" name="nik" class="form-control border-left-main" value="{{ old('nik', $user->nik) }}" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>

                    {{-- No Telepon --}}
                    <div class="form-group mb-3">
                        <label for="no_telp" class="form-label">No Telepon</label>
                        <input type="text" id="no_telp" name="no_telp" class="form-control border-left-main" value="{{ old('no_telp', $user->no_telp) }}" maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <select id="alamat" name="alamat" class="form-control border-left-main">
                            @foreach([
                                'Br. Batubayan', 'Br. Dlodpasar', 'Br. Gunung', 'Br. Jempeng',
                                'Br. Jempeng Kauh', 'Br. Ketogan', 'Br. Mambul', 'Br. Pegongan',
                                'Br. Raketan', 'Br. Sukajati', 'Br. Tabah', 'Br. Tebejero'
                            ] as $alamat)
                                <option value="{{ $alamat }}" {{ $user->alamat == $alamat ? 'selected' : '' }}>
                                    {{ $alamat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Email --}}
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control border-left-main" value="{{ old('email', $user->email) }}" required>
                    </div>

                    {{-- Tombol simpan --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary w-100 w-md-auto">Kembali</a>
                        <button type="submit" class="btn btn-primary w-100 w-md-auto">Simpan Perubahan</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/heic2any/dist/heic2any.min.js"></script>
<!-- Cropper.js CSS -->
<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet">
<!-- Cropper.js JS -->
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>


<script>
let cropper;

function handleFile(event) {
    const file = event.target.files[0];
    if (!file) return;

    const fileExt = file.name.split('.').pop().toLowerCase();
    const modal = document.getElementById('crop-modal');
    const imageElement = document.getElementById('image-to-crop');

    const showCropModal = (src) => {
        imageElement.src = src;
        modal.style.display = 'block';
        cropper = new Cropper(imageElement, {
            aspectRatio: 1, // Square crop, bisa disesuaikan
            viewMode: 1
        });
    };

    if (fileExt === 'heic' || fileExt === 'heif') {
        heic2any({
            blob: file,
            toType: "image/jpeg",
            quality: 0.8
        })
        .then(function(convertedBlob) {
            const reader = new FileReader();
            reader.onload = function (e) {
                showCropModal(e.target.result);
            };
            reader.readAsDataURL(convertedBlob);
        })
        .catch(() => alert("Gagal mengkonversi HEIC"));
    } else if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
            showCropModal(e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        alert("File tidak didukung");
        event.target.value = '';
    }
}

document.getElementById('crop-cancel').addEventListener('click', () => {
    cropper.destroy();
    document.getElementById('crop-modal').style.display = 'none';
    document.getElementById('foto').value = '';
});

document.getElementById('crop-confirm').addEventListener('click', () => {
    const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400
    });

    const croppedData = canvas.toDataURL("image/jpeg", 0.8);

    // Preview
    document.getElementById('foto-profil').src = croppedData;

    // Simpan ke input hidden
    document.getElementById('cropped_image').value = croppedData;

    cropper.destroy();
    document.getElementById('crop-modal').style.display = 'none';
});
</script>

@endpush

