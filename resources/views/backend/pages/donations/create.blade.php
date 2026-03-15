@extends('layouts.vertical', ['subtitle' => 'Donation Create'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Donations', 'subtitle' => 'Create'])

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">New Donation</h5>
        </div>

        <div class="card-body">
            <div id="message"></div>

            <form id="createDonationForm" action="{{ route('admin.donations.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Employee (Optional)</label>
                        <select name="employee_id" class="form-select">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->employee_no }} - {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Beneficiary Name</label>
                        <input type="text" name="beneficiary_name" class="form-control" placeholder="Ex: Ahmed Farooq" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Donation Type</label>
                        <input type="text" name="donation_type" class="form-control" placeholder="Ex: Medical Support" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0" name="amount" class="form-control" placeholder="Ex: 5000.00">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Donation Date</label>
                        <input type="date" name="donation_date" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Ex: Company donation support">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="4" placeholder="Enter remarks"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Donation</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('createDonationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json"
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    return {
                        status: response.status,
                        body: data
                    };
                })
                .then(result => {
                    let messageBox = document.getElementById('message');

                    if (result.status === 200 && result.body.success) {
                        messageBox.innerHTML = `<div class="alert alert-success">${result.body.message}</div>`;

                        setTimeout(() => {
                            window.location.href = result.body.redirect;
                        }, 1200);
                    } else {
                        let errors = result.body.errors ? Object.values(result.body.errors).flat().join('<br>') : 'Something went wrong.';
                        messageBox.innerHTML = `<div class="alert alert-danger">${errors}</div>`;
                    }
                })
                .catch(error => {
                    document.getElementById('message').innerHTML =
                        `<div class="alert alert-danger">Error: ${error}</div>`;
                });
        });
    </script>
@endsection
