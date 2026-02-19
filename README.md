# Laravel Student CRUD Project

คู่มือการติดตั้งและใช้งานโปรเจค Student CRUD ด้วย Laravel

--------------------------------------------

## 1️⃣ ติดตั้ง Composer
ดาวน์โหลดได้ที่:
https://getcomposer.org/

ตรวจสอบการติดตั้ง:
composer -v

--------------------------------------------

## 2️⃣ สร้างโปรเจค Laravel

composer create-project laravel/laravel student-crud
cd student-crud

--------------------------------------------

## 3️⃣ ตั้งค่าฐานข้อมูล

แก้ไขไฟล์ .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ชื่อฐานข้อมูล
DB_USERNAME=root
DB_PASSWORD=root

--------------------------------------------

## 4️⃣ กำหนด Route (routes/web.php)

use Illuminate\\Support\\Facades\\Route;
use App\\Http\\Controllers\\StudentController;

Route::get('/', [StudentController::class, 'index']);
Route::post('/add', [StudentController::class, 'add']);
Route::post('/update/{id}', [StudentController::class, 'update']);
Route::get('/delete/{id}', [StudentController::class, 'delete']);

--------------------------------------------

## 5️⃣ สร้าง Model + Migration + Controller

คำสั่ง:
php artisan make:model Student -mc

--------------------------------------------

### Model (app/Models/Student.php)

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = ['name', 'email'];
}

--------------------------------------------

### Migration

public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamps();
    });
}

รันคำสั่งสร้างตาราง:
php artisan migrate

--------------------------------------------

### Controller (app/Http/Controllers/StudentController.php)

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students', compact('students'));
    }

    public function add(Request $request)
    {
        Student::create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $student->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect('/');
    }

    public function delete($id)
    {
        Student::destroy($id);
        return redirect('/');
    }
}

--------------------------------------------

## 6️⃣ สร้าง View

สร้างไฟล์:
resources/views/students.blade.php

วางโค้ดหน้าเว็บ Bootstrap CRUD UI ลงไป
<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">Student Management System</h2>

    <!-- Add Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Add Student</div>
        <div class="card-body">
            <form action="/add" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col">
                        <button class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Student Table -->
    <div class="card">
        <div class="card-header bg-dark text-white">Student List</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>

                @foreach($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            onclick="editStudent('{{ $student->id }}','{{ $student->name }}','{{ $student->email }}')">
                            Edit
                        </button>

                        <a href="/delete/{{ $student->id }}" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete?')">
                           Delete
                        </a>
                    </td>
                </tr>
                @endforeach

            </table>
        </div>
    </div>

</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <input type="text" name="name" id="edit_name" class="form-control mb-2" required>
                    <input type="email" name="email" id="edit_email" class="form-control mb-2" required>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editStudent(id, name, email) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;

    document.getElementById('editForm').action = "/update/" + id;

    var modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}
</script>

</body>
</html>

--------------------------------------------

## 7️⃣ รันโปรเจค

php artisan serve

เปิดเว็บที่:
http://127.0.0.1:8000

--------------------------------------------

🎉 เสร็จสิ้น Student CRUD พร้อมใช้งาน
