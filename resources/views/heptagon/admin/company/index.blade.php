<x-heptagon.layout>
    <div class="container">
    <h2>Company Dashboard</h2>
    <a href="{{ route('companies.create') }}" class="btn btn-dark">Create Company</a>
    <div class="row">
        <div class="col-md-8">
            <div class="table-responsive h-bg-white">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Logo</th>
                            <th scope="col">No. of employees</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($companies) && $companies->count())
                            @foreach ($companies as $key => $company)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td><a href="{{ route('companies.show', $company->id) }}">{{ $company->name }}</a></td>
                                <td>
                                    <img src="{{ $company->logo }}" class="img-thumbnail"  width="40"
                                    height="40" alt="{{ $company->name }}" title="{{ $company->name }}">
                                </td>
                                <td>{{ $company->employees_count }}</td>
                                <td>{{ $company->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" type="button" id="actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="actions">
                                          <a class="dropdown-item" href="{{ route('companies.show', $company->id) }}">View</a>
                                          <a class="dropdown-item" href="{{ route('companies.edit', $company->id) }}">Edit</a>
                                          <a class="dropdown-item" href="{{ route('companies.destroy', $company->id) }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form').submit();"> {{ __('Delete') }} </a>
                                            <form id="delete-form" action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                      </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <th scope="row">{{ __('Data not found.') }}</th>
                        </tr>
                        @endif
                    </tbody>
                </table>

                {{ $companies->links() }}
            </div>
        </div>
        <div class="col-md-4">
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <label for="">Choose your xls/csv File :</label>
                <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="import" name="excel_file" aria-describedby="import">
                    <label class="custom-file-label" for="import">Choose file</label>
                </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-up-circle"></i> Bulk Upload</button>
                <button type="button" class="btn btn-outline-dark"><a href="{{ route('download.template') }}" id="downloadTemplate"><b>Download template</b></a></button>
            </form>
        </div>
    </div>
</div>
</x-heptagon.layout>
