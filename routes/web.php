<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Student;

Route::get('/', function () {
    $students = Student::all();
    return view('home', compact('students'));
});

Route::post('/add', function (Request $request) {
    Student::create($request->all());
    return redirect('/');
});

Route::post('/update/{id}', function (Request $request, $id) {
    $student = Student::find($id);
    $student->update($request->all());
    return redirect('/');
});

Route::get('/delete/{id}', function ($id) {
    Student::destroy($id);
    return redirect('/');
});
