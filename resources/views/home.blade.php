<!-- resources/views/users/index.blade.php -->
@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Student List</h1>
        <a href="{{ route('student-create') }}" class="btn btn-primary">Add Student</a>

        <table id="users-table" class="display">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Student Name</th>
                    <th>Class Teacher</th>
                    <th>Class</th>
                    <th>Admission Date</th>
                    <th>Yearly Fees</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>

        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('get-data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'student_name', name: 'student_name' },
                    { data: 'teacher_name', name: 'teacher_name' },
                    { data: 'class', name: 'class' },
                    { data: 'admission_date', name: 'admission_date' },
                    { data: 'yearly_fees', name: 'yearly_fees' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }

                ]
            });
        });
    </script>
@endsection
