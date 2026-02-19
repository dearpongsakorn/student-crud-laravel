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

--------------------------------------------

## 7️⃣ รันโปรเจค

php artisan serve

เปิดเว็บที่:
http://127.0.0.1:8000

--------------------------------------------

🎉 เสร็จสิ้น Student CRUD พร้อมใช้งาน
