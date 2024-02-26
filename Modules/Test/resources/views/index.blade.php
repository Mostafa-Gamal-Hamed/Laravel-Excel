@extends('test::layouts.master')

@section('content')
    {{-- Insert data start --}}
    <div class="container mt-3">
        {{-- Form start --}}
        <div class="d-flex justify-content-center">
            <form action="{{ url('check') }}" method="post" class="text-center w-50 shadow p-3" enctype="multipart/form-data">
                @csrf
                <input type="file" name="excel" class="form-control"><br>
                @error('excel')
                    <span class="text-danger"><i class="mdi mdi-close"></i> {{ $message }}</span>
                @enderror
                <br>
                <button type="submit" class="btn btn-info w-50">Upload</button>
            </form>
        </div>
        {{-- Form end --}}
    </div>
    {{-- Insert data end --}}

    {{-- Show all data start --}}
    <div class="mt-5">
        {{-- Success message start --}}
        @if (session()->get('success'))
            <div class="alert alert-success text-center mb-2">
                <i class="mdi mdi-check"></i> {{ session()->get('success') }}
            </div>
        @endif
        {{-- Error message --}}
        @if (session()->get('error'))
            <div class="container">
                <div class="alert alert-danger text-center mb-3">
                    <i class="mdi mdi-check"></i> {{ session()->get('error') }}
                </div>
            </div>
        @endif

        {{-- Show and hidden table --}}
        <div>
            <button type="submit" onclick="toggleTables()" class="btn btn-warning mx-3">Valid & Invalid</button>
        </div>
        {{-- Tables --}}
        <div class="d-flex">
            <div class="col valid border-end" id="valid" style="display: block;">
                <h1 class="text-center text-primary">Valid Table</h1>
                <table class="table text-center">
                    <thead>
                        <tr>
                            @foreach ($validColumns as $column)
                                <th>{{$column}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($valid as $row)
                            <tr>
                                @foreach ($row as $data)
                                    <td>{{$data}}</td>
                                @endforeach
                                <td>
                                    <form action="export/{{$validTable}}/{{$row->id}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">Export</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col invalid" id="invalid" style="display:none;">
                <h1 class="text-center text-secondary">InValid Table</h1>
                <table class="table text-center">
                    <thead>
                        <tr>
                            @foreach ($invalidColumns as $column)
                                <th>{{$column}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($invalid as $row)
                            <tr>
                                @foreach ($row as $data)
                                    <td>{{$data}}</td>
                                @endforeach
                                <td>
                                    <form action="export/{{$invalidTable}}/{{$row->id}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">Export</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Show all data end --}}
@endsection

{{-- JS --}}
<script>
    function toggleTables() {
        var valid   = document.getElementById('valid');
        var inValid = document.getElementById('invalid');
        if(valid.style.display === "block") {
            valid.style.display = "none";
            inValid.style.display = "block";
        }else{
            valid.style.display = "block";
            inValid.style.display = "none";
        }
    }
</script>