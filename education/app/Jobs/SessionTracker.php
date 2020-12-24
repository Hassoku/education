<?php

namespace App\Jobs;

use App\Helpers\CommonHelper;
use App\Models\LearningSessions\LearningSession;
use App\Models\Users\Students\StudentBalance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SessionTracker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $learningSession_id;

    public function __construct($learningSession_id)
    {
        //
        $this->learningSession_id = $learningSession_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $loopController = true;

        // get the learningSession
        $learningSession = LearningSession::find($this->learningSession_id);

        // getting participants
        $student_id = $learningSession->student_id;
        $tutor_id = $learningSession->tutor_id;

        // getting studentBalance
        $studentBalance = StudentBalance::where(['student_id' => $student_id])->get()->last(); // get the latest entry of student
        $remaining_slots = $studentBalance->remaining_slots;

        /*        $channel = "student.learning_session.updates." . $student_id;
                $event = "learning_session.update.event";
                $data = [
        //                        "remaining_slots" => $studentBalance->remaining_slots,
        //                        "consumed_slot" => $learningSession->consumed_slot,
                    "msg" => "Duzz krenss"
                ];
                CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);*/

        // loop for update session participants
        while ($loopController == true || $remaining_slots > 0) {

            // deducting the 1 slot from remaining slots of student
            $remaining_slots--;
            $studentBalance->remaining_slots = $remaining_slots;
            $studentBalance->update();

            // updating consumed slots
            // in learning session
            $learningSession->consumed_slot++;
            $learningSession->update();
            // in student balances
            $studentBalance->consumed_slots++;
            $studentBalance->update();

            // pusher notification to student
            /// send session data to student
            $channel = "student.learning_session.updates." . $student_id;
            $event = "learning_session.update.event";
            $data = [
                "remaining_slots" => $studentBalance->remaining_slots,
                "consumed_slot" => $learningSession->consumed_slot
            ];
            CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);


            // check weather learningSession is of then stop the loop
            if ($learningSession->status == 0) {
                $loopController = false;
                break; // break the loop
            }

            // sleep for every 14-sec
            sleep(14);
        }
    }
}
