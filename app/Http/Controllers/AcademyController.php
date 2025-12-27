<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function index()
    {
        $lessons = Lesson::orderBy('order')->get();
        return view('academy.index', compact('lessons'));
    }

    public function lesson(Lesson $lesson)
    {
        // Check if lesson is locked
        $isLocked = !$lesson->is_free && !auth()->user()->hasAnyRole(['admin', 'premium']);

        $previousLesson = Lesson::where('order', '<', $lesson->order)->orderBy('order', 'desc')->first();
        $nextLesson = Lesson::where('order', '>', $lesson->order)->orderBy('order', 'asc')->first();

        return view('academy.lesson', compact('lesson', 'previousLesson', 'nextLesson', 'isLocked'));
    }
}
