<div class="form-group">
    <label for="name" class="col-md-2 control-label">Buku</label>
    <div class="col-md-4">
        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : ''}}" id="title" name="title" placeholder="Judul Buku" value="{{ old('name') }}" autofocus>
        @if ($errors->has('title'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
        @endif
    </div>

    <br>
    
    <label for="name" class="col-md-2 control-label">Penulis</label>
    <div class="col-md-4">
        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : ''}}" id="name" name="name" placeholder="Nama Penulis" value="{{ old('name') }}" autofocus>
        @if ($errors->has('name'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>

    <br>
    
    <label for="name" class="col-md-2 control-label">Jumlah Halaman</label>
    <div class="col-md-4">
        <input type="number" class="form-control{{ $errors->has('name') ? ' is-invalid' : ''}}" id="jumlah_halaman" name="jumlah_halaman" placeholder="Jumlah Halaman" value="{{ old('name') }}" autofocus>
        @if ($errors->has('name'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-md-4 col-md-offset-2">
        <button type="submit" class="btn btn-primary">Tambah</button>
    </div>
</div> 