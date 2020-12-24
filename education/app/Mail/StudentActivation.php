<?php

namespace App\Mail;


use App\Models\Users\Students\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentActivation extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The customer instance.
     *
     * @var student
     */
    protected $student;

    /**
     * Create a new message instance.
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('student.emails.emailActivation')->subject('Activate your account')
            ->with([
                'student' => $this->student,
            ]);
    }
}
