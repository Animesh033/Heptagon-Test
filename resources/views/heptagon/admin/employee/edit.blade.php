<x-heptagon.layout>
    <x-slot name="pageHeading">Update {{  $employee->first_name }} 's info <span class="float-right"><a href="{{ route('employees.index') }}"><i class="bi bi-arrow-left-circle-fill"></i></a></span></x-slot>
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="form-row">
                <div class="col-md-6"><div class="response-message"></div></div>
            </div>
            <div class="h-bg-white">
                <form method="POST" action="{{ route('employees.update', $employee->id) }}" class="needs-validation h-bg-white" id="employeeForm" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="status">Company</label>
                        <select class="custom-select" id="status" name="company_id">
                            <option selected disabled value="">Select..</option>
                            @if (isset($companies) && $companies->count())
                                @foreach ($companies as $company)
                                    <option {{ isset($employee) && $employee->company->id == $company->id ?  'selected' : ''}} value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Please select status.
                        </div>
                            </div>
                        <div class="col-md-4 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" value="{{ $employee->first_name }}" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        </div>
                        <div class="col-md-4 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" value="{{ $employee->last_name }}" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email }}" required>
                        <div class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}" required>
                            <div class="invalid-feedback">
                                Please provide a valid phone.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="designation">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" value="{{ $employee->designation }}" required>
                            <div class="invalid-feedback">
                                Please enter  designation.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        <select class="custom-select" id="status" name="status">
                            <option {{ strtolower($employee->status) == 'active' ? 'selected' : '' }} value="active">Active</option>
                            <option {{ strtolower($employee->status) == 'inactive' ? 'selected' : '' }} value="inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select status.
                        </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" id="submitAddEmpForm" type="submit">Update employee</button>
                </form>
            </div>
        </div>
    </div>
</div>
</x-heptagon.layout>
