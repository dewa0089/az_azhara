@extends('layout.main')
@section('title', 'Tambah Barang Rusak')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Barang Rusak</h4>
        <p class="card-description">Formulir Barang Rusak</p>
        <form action="{{ route('rusak.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label for="jenis_brg_rusak">Jenis Barang</label>
            <select name="jenis_brg_rusak" id="jenis_brg_rusak" class="form-control" required>
              <option selected disabled>Pilih Jenis</option>
              <option value="elektronik">Elektronik</option>
              <option value="mobiler">Mobiler</option>
              <option value="lainnya">Lainnya</option>
            </select>
            @error('jenis_brg_rusak')
              <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <div class="form-group">
            <label for="nama_barang">Nama Barang</label>

            <select name="elektronik_id" id="elektronik_id" class="form-control barang-select" style="display:none;">
              <option selected disabled>Pilih Barang Elektronik</option>
              @foreach ($elektronik as $item)
                <option 
                  value="{{ $item->id }}"
                  data-kode="{{ $item->kode_barang }}"
                  data-merk="{{ $item->merk }}"
                  data-type="{{ $item->type }}"
                  data-tanggal="{{ $item->tanggal_peroleh }}"
                  data-asal="{{ $item->asal_usul }}"
                  data-cara="{{ $item->cara_peroleh }}"
                  data-harga="{{ $item->harga_perunit }}"
                >
                  {{ $item->nama_barang }}
                </option>
              @endforeach
            </select>

            <select name="mobiler_id" id="mobiler_id" class="form-control barang-select" style="display:none;">
              <option selected disabled>Pilih Barang Mobiler</option>
              @foreach ($mobiler as $item)
                <option 
                  value="{{ $item->id }}"
                  data-kode="{{ $item->kode_barang }}"
                  data-merk="{{ $item->merk }}"
                  data-type="{{ $item->type }}"
                  data-tanggal="{{ $item->tanggal_peroleh }}"
                  data-asal="{{ $item->asal_usul }}"
                  data-cara="{{ $item->cara_peroleh }}"
                  data-harga="{{ $item->harga_perunit }}"
                >
                  {{ $item->nama_barang }}
                </option>
              @endforeach
            </select>

            <select name="lainnya_id" id="lainnya_id" class="form-control barang-select" style="display:none;">
              <option selected disabled>Pilih Barang Lainnya</option>
              @foreach ($lainnya as $item)
                <option 
                  value="{{ $item->id }}"
                  data-kode="{{ $item->kode_barang }}"
                  data-merk="{{ $item->merk }}"
                  data-type="{{ $item->type }}"
                  data-tanggal="{{ $item->tanggal_peroleh }}"
                  data-asal="{{ $item->asal_usul }}"
                  data-cara="{{ $item->cara_peroleh }}"
                  data-harga="{{ $item->harga_perunit }}"
                >
                  {{ $item->nama_barang }}
                </option>
              @endforeach
            </select>

            @error('elektronik_id')
              <label class="text-danger">{{ $message }}</label>
            @enderror
            @error('mobiler_id')
              <label class="text-danger">{{ $message }}</label>
            @enderror
            @error('lainnya_id')
              <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <!-- Field yang otomatis terisi -->
          <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <input type="text" id="kode_barang" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="merk">Merk</label>
            <input type="text" id="merk" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="type">Type</label>
            <input type="text" id="type" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="tanggal_peroleh">Tanggal Peroleh Barang</label>
            <input type="date" id="tanggal_peroleh" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="asal_usul">Asal Usul</label>
            <input type="text" id="asal_usul" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="cara_peroleh">Cara Perolehan</label>
            <input type="text" id="cara_peroleh" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="harga_perunit">Harga Per Unit Barang</label>
            <input type="text" id="harga_perunit" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="jumlah_brg_rusak">Jumlah Rusak</label>
            <input type="number" name="jumlah_brg_rusak" class="form-control" value="{{ old('jumlah_brg_rusak') }}" required>
            @error('jumlah_brg_rusak')
              <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <div class="form-group">
            <label for="gambar_brg_rusak">Gambar Barang Rusak</label>
            <input type="file" name="gambar_brg_rusak" class="form-control-file">
            @error('gambar_brg_rusak')
              <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <div class="form-group">
            <label for="tgl_rusak">Tanggal Rusak</label>
            <input type="date" name="tgl_rusak" class="form-control" value="{{ old('tgl_rusak') }}" required>
            @error('tgl_rusak')
              <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan') }}</textarea>
            @error('keterangan')
              <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary mr-2">Simpan</button>
          <a href="{{ route('rusak.index') }}" class="btn btn-light">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const jenisSelect = document.getElementById('jenis_brg_rusak');
  const elektronikSelect = document.getElementById('elektronik_id');
  const mobilerSelect = document.getElementById('mobiler_id');
  const lainnyaSelect = document.getElementById('lainnya_id');

  const kodeInput = document.getElementById('kode_barang');
  const merkInput = document.getElementById('merk');
  const typeInput = document.getElementById('type');
  const tanggalInput = document.getElementById('tanggal_peroleh');
  const asalInput = document.getElementById('asal_usul');
  const caraInput = document.getElementById('cara_peroleh');
  const hargaInput = document.getElementById('harga_perunit');

  jenisSelect.addEventListener('change', function () {
    // Sembunyikan semua select nama barang
    document.querySelectorAll('.barang-select').forEach(el => el.style.display = 'none');

    // Clear semua field otomatis
    kodeInput.value = '';
    merkInput.value = '';
    typeInput.value = '';
    tanggalInput.value = '';
    asalInput.value = '';
    caraInput.value = '';
    hargaInput.value = '';

    if (this.value === 'elektronik') {
      elektronikSelect.style.display = 'block';
    } else if (this.value === 'mobiler') {
      mobilerSelect.style.display = 'block';
    } else if (this.value === 'lainnya') {
      lainnyaSelect.style.display = 'block';
    }
  });

  // Event change untuk masing-masing select barang supaya isi field otomatis
  function onBarangChange(selectElement) {
    const selected = selectElement.options[selectElement.selectedIndex];
    if (!selected || selected.disabled) {
      kodeInput.value = '';
      merkInput.value = '';
      typeInput.value = '';
      tanggalInput.value = '';
      asalInput.value = '';
      caraInput.value = '';
      hargaInput.value = '';
      return;
    }
    kodeInput.value = selected.getAttribute('data-kode') || '';
    merkInput.value = selected.getAttribute('data-merk') || '';
    typeInput.value = selected.getAttribute('data-type') || '';
    tanggalInput.value = selected.getAttribute('data-tanggal') || '';
    asalInput.value = selected.getAttribute('data-asal') || '';
    caraInput.value = selected.getAttribute('data-cara') || '';
    hargaInput.value = selected.getAttribute('data-harga') || '';
  }

  elektronikSelect.addEventListener('change', () => onBarangChange(elektronikSelect));
  mobilerSelect.addEventListener('change', () => onBarangChange(mobilerSelect));
  lainnyaSelect.addEventListener('change', () => onBarangChange(lainnyaSelect));
</script>
@endsection
