<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .form-section {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<!-- Include navbar here -->
<?php include 'nav.php'; ?>

<div class="container">
    <h1 class="mb-4">Manage Courses</h1>

    <!-- Search Bar -->
    <div class="form-group">
        <input type="text" class="form-control" id="searchCourse" placeholder="Search for courses...">
    </div>

    <!-- Course Form -->
    <div class="form-section">
        <h2>Create/Update Course</h2>
        <form id="courseForm">
            <div class="form-group">
                <label for="courseName">Course Name</label>
                <input type="text" class="form-control" id="courseName" placeholder="Enter course name">
            </div>
            <div class="form-group">
                <label for="courseDescription">Course Description</label>
                <textarea class="form-control" id="courseDescription" rows="3" placeholder="Enter course description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Course</button>
        </form>
    </div>

    <!-- Courses Table -->
    <div class="form-section">
        <h2>Existing Courses</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="coursesTableBody">
                <!-- Dynamic content will be inserted here -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // Sample data - this would be replaced with data from your database
    const courses = [
        {id: 1, name: 'Course 1', description: 'Description 1'},
        {id: 2, name: 'Course 2', description: 'Description 2'}
    ];

    // Function to render courses in the table
    function renderCourses() {
        const tbody = $('#coursesTableBody');
        tbody.empty();
        courses.forEach(course => {
            tbody.append(`
                <tr>
                    <td>${course.id}</td>
                    <td>${course.name}</td>
                    <td>${course.description}</td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="editCourse(${course.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteCourse(${course.id})">Delete</button>
                    </td>
                </tr>
            `);
        });
    }

    // Function to edit a course
    function editCourse(id) {
        const course = courses.find(c => c.id === id);
        $('#courseName').val(course.name);
        $('#courseDescription').val(course.description);
        // Save the id to know which course is being edited
        $('#courseForm').data('courseId', id);
    }

    // Function to delete a course
    function deleteCourse(id) {
        const index = courses.findIndex(c => c.id === id);
        if (index !== -1) {
            courses.splice(index, 1);
            renderCourses();
        }
    }

    // Handle form submission
    $('#courseForm').submit(function(e) {
        e.preventDefault();
        const id = $('#courseForm').data('courseId');
        const name = $('#courseName').val();
        const description = $('#courseDescription').val();

        if (id) {
            // Update existing course
            const course = courses.find(c => c.id === id);
            course.name = name;
            course.description = description;
        } else {
            // Create new course
            const newId = courses.length ? courses[courses.length - 1].id + 1 : 1;
            courses.push({id: newId, name: name, description: description});
        }

        renderCourses();
        $('#courseForm')[0].reset();
        $('#courseForm').removeData('courseId');
    });

    // Initial render
    renderCourses();
</script>

</body>
</html>
