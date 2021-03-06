<x-heptagon.layout>
    <x-slot name="pageHeading">Employee Dashboard <span class="float-right"><a href="{{ route('companies.index') }}"><i class="bi bi-arrow-left-circle-fill"></i></a></span></x-slot>
    <div class="container">
    <a href="{{ route('employees.create') }}" class="btn btn-dark">Add Employee</a>
    <div class="row">
        <div class="col-md-12">
            <div class="form-row">
                <div class="col-md-6"><div class="response-message pt-2"></div></div>
            </div>
            <div class="table-responsive h-bg-white">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($employees) && $employees->count())
                            @foreach ($employees as $key => $employee)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td><a href="{{ route('employees.show', $employee->id) }}">{{ $employee->first_name }}</a></td>
                                <td>{{ $employee->last_name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->designation }}</td>
                                <td>{{ $employee->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" type="button" id="actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="actions">
                                          <a class="dropdown-item" href="{{ route('employees.show', $employee->id) }}">View</a>
                                          <a class="dropdown-item" href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                                          <a class="dropdown-item delete-emp" data-route="{{ route('employees.destroy', $employee->id) }}" href="javascript:void(0)"> {{ __('Delete') }} </a>
                                          {{-- <a class="dropdown-item" href="{{ route('employees.destroy', $employee->id) }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form').submit();"> {{ __('Delete') }} </a> --}}
                                            <form class="delete-emp-form" action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-none">
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

                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>
</x-heptagon.layout>
