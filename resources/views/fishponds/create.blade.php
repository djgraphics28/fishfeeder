@extends('layouts.app')

@section('title', 'Create Fishpond')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Fishpond</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('fishponds.index') }}">Fishponds</a></li>
                        <li class="breadcrumb-item active">Create Fishpond</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Create Fishpond</div>

                        <div class="card-body">
                            <form action="{{ route('fishponds.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description"
                                        class="form-control summernote @error('description') is-invalid @enderror"></textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="device">Device</label>
                                    <select name="device" id="device"
                                        class="form-control @error('device') is-invalid @enderror">
                                        <option value="">Select Device</option>
                                        @foreach ($devices as $device)
                                            <option value="{{ $device->id }}"
                                                data-image="{{ $device->getFirstMediaUrl('device-image') }}">
                                                {{ $device->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="device-image-preview" class="mt-2">
                                        <a href="" class="image-popup d-none" id="preview-link">
                                            <img src="" alt="Device Image" width="150"
                                                class="d-none img-thumbnail">
                                        </a>
                                    </div>
                                    @error('device')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <script>
                                        document.getElementById('device').addEventListener('change', function() {
                                            const selectedOption = this.options[this.selectedIndex];
                                            const imageUrl = selectedOption.getAttribute('data-image');
                                            const imagePreview = document.querySelector('#device-image-preview img');
                                            const previewLink = document.querySelector('#preview-link');

                                            if (imageUrl) {
                                                imagePreview.src = imageUrl;
                                                previewLink.href = imageUrl;
                                                imagePreview.classList.remove('d-none');
                                                previewLink.classList.remove('d-none');
                                            } else {
                                                imagePreview.classList.add('d-none');
                                                previewLink.classList.add('d-none');
                                            }
                                        });

                                        // Initialize Modal
                                        $(document).ready(function() {
                                            $('.image-popup').on('click', function(e) {
                                                e.preventDefault();
                                                let imgSrc = $(this).attr('href');
                                                let modal = `
            <div class="modal fade" id="imageModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="${imgSrc}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>`;
                                                $(modal).modal('show');
                                            });
                                        });
                                    </script>
                                </div>

                                <div class="form-group">
                                    <label for="fishpondImage">Fishpond Image</label>
                                    <input type="file" name="fishpondImage" id="fishpondImage"
                                        class="form-control @error('fishpondImage') is-invalid @enderror" accept="image/*"
                                        onchange="previewLogo(event)">
                                    @error('fishpondImage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="mt-3">
                                        <img id="logo-preview" src="#" alt="Fishpond Image Preview"
                                            class="img-thumbnail d-none" style="max-height: 200px;">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Create Fishpond</button>
                                <a href="{{ route('fishponds.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('logo-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
            }
        }
    </script>

    @push('scripts')
        <script>
            $(function() {
                // Summernote
                $('#description').summernote()

                // CodeMirror
                CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                    mode: "htmlmixed",
                    theme: "monokai"
                });
            })
        </script>
    @endpush

@endsection
