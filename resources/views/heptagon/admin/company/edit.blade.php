<x-heptagon.layout>
    <x-slot name="pageHeading">Update {{  $company->name }}'s info <span class="float-right"><a href="{{ route('companies.index') }}"><i class="bi bi-arrow-left-circle-fill"></i></a></span></x-slot>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="h-bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                <img src="{{ $company->logo }}" class="img-thumbnail"  width="68" height="68" alt="{{ $company->name }}" title="{{ $company->name }}">
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="companyName">Name</label>
                                <input type="text" class="form-control" id="companyName" name="name" value="{{ $company->name }}" required>
                                <div class="invalid-feedback"> Please enter company name.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="companyEmail">Email</label>
                                <input type="text" class="form-control" id="companyEmail" name="email" value="{{ $company->email }}">
                                <div class="invalid-feedback"> Please enter company email.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="companyLogo">Logo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="companyLogo" name="logo">
                                    <label class="custom-file-label" for="companyLogo">Choose file</label>
                                    <div class="invalid-feedback"> Please choose a company logo.</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="companyWebsite">Website</label>
                                <input type="text" class="form-control" id="companyWebsite" name="website" value="{{ $company->website }}">
                                <div class="invalid-feedback"> Please enter a company website.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="companyStatus">Status</label>
                                <select class="custom-select" id="companyStatus" name="status" value="{{ $company->status }}">
                                    <option {{ strtolower($company->status) == 'active' ? 'selected' : '' }} value="active">Active</option>
                                    <option {{ strtolower($company->status) == 'inactive' ? 'selected' : '' }} value="inactive">Inactive</option>
                                </select>
                                <div class="invalid-feedback"> Please select a status of company.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-heptagon.layout>
