@extends('layouts.vertical', ['subtitle' => 'Donation Edit'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Donations', 'subtitle' => 'Edit'])

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Donation</h5>
        </div>

        <div class="card-body">
            <div id="message"></div>

            <form id="editDonationForm" action="{{ route('admin.donations.update', $donation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Employee (Optional)</label>
                        <select name="employee_id" class="form-select">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $donation->employee_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->employee_no }} - {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Beneficiary Name</label>
                        <input type="text" name="beneficiary_name" class="form-control" value="{{ $donation->beneficiary_name }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Donation Type</label>
                        <input type="text" name="donation_type" class="form-control" value="{{ $donation->donation_type }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0" name="amount" class="form-control" value="{{ $donation->amount }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Donation Date</label>
                        <input type="date" name="donation_date" class="form-control" value="{{ optional($donation->donation_date)->format('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="Pending" {{ $donation->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Approved" {{ $donation->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Completed" {{ $donation->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $donation->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="{{ $donation->description }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="4">{{ $donation->remarks }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Donation</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('editDonationForm').addEventListener('submit', function(e) {
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
