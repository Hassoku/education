<?php

namespace App\Events;

use App\Models\LearningSessions\LearningSessionRequest;
use App\Models\Users\Students\Student;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendLearningSessionRequestToTutorEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    private $learning_session_request;
    public function __construct(LearningSessionRequest $learningSessionRequest)
    {
        $this->learning_session_request = $learningSessionRequest;
    }


    public function broadcastWith()
    {
        return [
            'student_name' => $this->learning_session_request->student()->name,
            'msg' => 'Requesting For Learning Session',
        ];
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Learning_session.request.tutor.'.$this->learning_session_request->tutor_id);
    }
}
