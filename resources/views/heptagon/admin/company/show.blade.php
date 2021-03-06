<x-heptagon.layout>
    <div class="container">
    <h2>{{ $company->name }} Dashboard <span class="float-right"><a href="{{ route('companies.index') }}"><i class="bi bi-arrow-left-circle-fill"></i></a></span></h2>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive companyList h-bg-white">
                <table class="table table-borderless company-list">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Website</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <th scope="col">Logo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($company) && $company)
                            <tr>
                                <td><a href="{{ route('companies.show', $company->id) }}">{{ $company->name }}</a></td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->website }}</td>
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
                                <td>
                                    <img src="{{ $company->logo }}" class="img-thumbnail"  width="300"
                                    height="200" alt="{{ $company->name }}" title="{{ $company->name }}">
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-heptagon.layout>
