<?php

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
//use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;



/////////////////////////////////////////////////

Route::get('/', function (){
    return redirect()->route('tasks.index');
});


Route::get('/tasks', function (){
    return view("index", [
        'tasks' => Task::latest() //->where('completed', true)
        ->paginate(10)
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')
->name('tasks.create');


Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', [
      'task'=> $task]);
  })->name('tasks.edit');


Route::get('/tasks/{task}', function (Task $task) {
  return view('show', [
    'task'=> $task]);
})->name('tasks.show');




Route::post('/tasks', function(TaskRequest $request){
  
  
  
    //$data = $request->validated();
    //$task = new Task;
    //$task->title = $data['title'];
    //$task->description = $data['description'];
    //$task->long_description = $data['long_description'];
    //$task->save();



    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ["task" => $task->id])
    ->with('success', 'Task created successfully');
})->name('tasks.store');


Route::put('/tasks/{task}', function(Task $task, TaskRequest $request){
    
    
    //$data = $request->validated();
    //$task = Task::findorFail($task);
    //$task->title = $data['title'];
    //$task->description = $data['description'];
    //$task->long_description = $data['long_description'];
    //$task->save();



    $task->update($request->validated());

    return redirect()->route('tasks.show', ["task" => $task->id])
    ->with('success', 'Task updated successfully');
})->name('tasks.update');



Route::delete('/tasks/{task}', function (Task $task){
    $task->delete();

    return redirect()->route('tasks.index')
        ->with('success','Task deleted successfully');
})->name('tasks.destroy');

Route::put('tasks/{task}/toggle-complete', function(Task $task){
    //$task->completed=!$task->completed; moodel update at Task.php
    //$task->save();

    $task->togglecomplete();

    return redirect()->back()->with('success', 'Task update successfully');
})->name('tasks.toggle-complete');

//Route::get("/xx", function(){
//    return "Hello";
//})->name("Name");

//Route::get("/hallo", function(){
//    return redirect()->route('Name');
//});


//Route::get('/greet/{name}', function($name){

  //  return "Hello " . $name . " !";

//});

Route::fallback(function(){
    return "Still got somewhere";
});