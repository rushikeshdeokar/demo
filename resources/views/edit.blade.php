<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Student</h1>
        <form id="student-form" method="POST" action="{{ route('student-update', $student->id) }}">
            @csrf

            <div class="mb-3">
                <label for="student_name" class="form-label">Student Name:</label>
                <input class="form-control" type="text" id="student_name" name="student_name" value="{{$student->student_name}}" required>
            </div>

            <div class="mb-3">
                <label for="class_teacher_id" class="form-label">Select Teacher:</label>
                <select id="class_teacher_id" name="class_teacher_id" class="form-select" required>
                    <option value="" disabled>Select Teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $teacher->id == old('class_teacher_id', $student->class_teacher_id) ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="class" class="form-label">Class:</label>
                <input class="form-control" type="text" id="class" name="class" value="{{$student->class}}" required>
            </div>

            <div class="mb-3">
                <label for="admission_date" class="form-label">Admission Date:</label>
                <input class="form-control" type="date" id="admission_date" name="admission_date" value="{{$student->admission_date}}" required>
            </div>

            <div class="mb-3">
                <label for="yearly_fees" class="form-label">Yearly Fees:</label>
                <input class="form-control" type="number" step="0.01" id="yearly_fees" name="yearly_fees" value="{{$student->yearly_fees}}" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#student-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        window.location.href = response.url;
                        toastr.success('Student updated successfully.');
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        toastr.error(errorMessage);
                    }
                });
            });
        });
    </script>
</body>
</html>
