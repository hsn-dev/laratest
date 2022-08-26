<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseTeacher;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function() {
    // 1. Get all courses and their teachers
    // 2. Show only those teachers having 'PHD'
    // 3. Show only those courses having atleast one teacher

   $q1 = Course::with(['teachers' => function($q){
               $q->where('qualification', 'PHD');
        }])->whereHas('teachers')->get();

   $q1 = Course::query()->withWhereHas('teachers', function($q){ // atleast one teacher and having qualification as 'phd's
       $q->where('qualification', 'PHD');
   })->get();

//   $q1 = Course::withCount('teachers')->get();
   return $q1;

    $q = "
        SELECT
            *
        FROM
            courses c
        LEFT JOIN
            course_teacher ct
            on c.id = ct.course_id
   ";


   $q2 = "
        SELECT c.id 'course_id', t.id 'teacher_id', c.name 'course', t.name 'teacher', t.qualification 'qualification'
        FROM courses c
        LEFT JOIN
            course_teacher ct
            on c.id = ct.course_id
        LEFT JOIN
            teachers t
            on t.id = ct.teacher_id
        /*WHERE
            course_id IN (SELECT DISTINCT course_id FROM course_teacher)*/
        WHERE
            t.qualification = 'PHD'
        ORDER BY course_id";

   $q2_res = DB::select($q2);
//   return $q2_res;

    $ct = CourseTeacher::query()->find(1);
    return $ct->with('teacher', 'course')->get();
});

Route::get('t1', function(){

    DB::enableQueryLog();
    // All Users with their posts
//     return User::query()->with('posts')->get();

    // All Users having tier = 'platinum' with their posts
//     return User::query()->where('tier', 'platinum')->with('posts')->get();

    // All users but only those posts having likes >= 10
//    User::query()->with(['posts' => function($q){
//        $q->where('likes', '>=', 10);
//    }])->get();

    // Add extra condition on where exist clause.
//    return User::query()->with('posts')->whereRelation('posts', 'likes', '>=', '10')->get();

    // Only Those Users having atleast 1 post
//    User::query()->whereHas('posts')->with('posts')->get();

    // Only Those Users having no posts
//    User::query()->whereDoesntHave('posts')->with('posts')->get();

    // Only Those Users where post count >= 3
//    $users = User::query()->withCount('posts')->get();
//    $users->where('posts_count', '>=', 3);

    // Single user with his posts where likes >= 10
//    $user = User::query()->find(1);
//    $user->posts()->where('likes', '>=', 10)->get();

    // Get all posts of a user with his posts and comments
    /*$user = User::query()->find(1);
    $user->posts()->with(
                            [
                                'comments.user' => function($q){
                                    $q->select('id', 'name');
                                },
                                'comments' => function($q){
                                    $q->select('user_id', 'post_id', 'id', 'comment');
                                }
                            ])->get();*/

    // Get all categories with their posts
//     return Category::query()->whereHas('posts')->with('posts')->get();

    // Get all categories with their post count where likes > 3
//     return Category::query()->withCount([ 'posts' => function($q){
//        $q->where('likes', '>=', 3);
//    }])->get();

    dd(DB::getQueryLog());
});
