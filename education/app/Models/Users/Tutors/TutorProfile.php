<?php

namespace App\Models\Users\Tutors;

use App\Helpers\ReservationCommonHelper;
use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use Illuminate\Support\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Collection;

class TutorProfile extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'tutor_id',
            'picture',
            'video',
/*            'tutoring_style',*/
            'education',
            'tutor_post',
            'tutor_intro',
            'moderate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /*
     * Calculating The rating of tutor
     * return: rating, like: 4.76
     *
     * Formula: (5*252 + 4*124 + 3*40 + 2*29 + 1*33) / (252+124+40+29+33) = 4.11
     * */
    public function rating(){
        $tutor_ratings = $this->tutor_ratings;
        if($tutor_ratings->count() > 0){
            /*
    * $rating_frequency[0] = 0; // will not use it
    * $rating_frequency[1] = 25;
    * $rating_frequency[2] = 30;
    * $rating_frequency[3] = 58;
    * $rating_frequency[4] = 98;
    * $rating_frequency[5] = 100;
    * */
            $rating_frequency = [0,0,0,0,0,0]; // hold the count of rating with corresponding ratting(1,2,3,4,5)

            /*
             * if $tutor_rating is N than $rating_frequency[N]++
             * where N can be >= 1 and <= 5.
             * Note: number can't be < 1 or > 5
             * */
            foreach ($tutor_ratings as $tutor_rating){
                $rating = $tutor_rating->rating;
                if($rating >= 1 && $rating <= 5){
                    $rating_frequency[$rating]++; // add 1 to corresponding $rating_frequency
                }
            }

            /*
             * Formula: (5*252 + 4*124 + 3*40 + 2*29 + 1*33) / (252+124+40+29+33) = 4.11
             * */
            $sum_of_frequency_with_rating = 0;  //(5*252 + 4*124 + 3*40 + 2*29 + 1*33)
            // '/'
            $sum_of_frequency = 0;              // (252+124+40+29+33)
            // ' = '
            $total_rating = 0.0;                // 4.11
            for($i = 1; $i < count($rating_frequency); $i++){

                //(252+124+40+29+33)
                $sum_of_frequency += $rating_frequency[$i];

                //(5*252 + 4*124 + 3*40 + 2*29 + 1*33)
                $sum_of_frequency_with_rating += $i * $rating_frequency[$i];

            }

            // 4.11
            $total_rating = $sum_of_frequency_with_rating / $sum_of_frequency;

            /*
             * total of rating and total of raters
             *
             * round( $total_rating, 1, PHP_ROUND_HALF_EVEN); // 1.55 = 1.6, 1.54 = 1.5
             * */
            return ['total_rating' => round( $total_rating, 1, PHP_ROUND_HALF_EVEN), 'total_raters' => $sum_of_frequency, 'rating_frequencies' => $rating_frequency];
        }else{
            return ['total_rating' => 0, 'total_raters' => 0, 'rating_frequencies' => [0,0,0,0,0,0] ];
        }
    }

    /*
     * Tutor day wise weekly availabilities
     * Sunday : timings(12:00 Am to 11:00 PM)
     * Monday : timings(12:00 Am to 11:00 PM)
     * Tuesday : timings(12:00 Am to 11:00 PM)
     * Wednesday : timings(12:00 Am to 11:00 PM)
     * Thursday : timings(12:00 Am to 11:00 PM)
     * Friday : timings(12:00 Am to 11:00 PM)
     * Saturday : timings(12:00 Am to 11:00 PM)
     *    */
    public function day_wise_weekly_availabilities(){
        $tutorAvailabilities = $this->tutor_availabilities;
        $day_wise_weekly_availabilities = [];
        $days_frequency = [
            'SUN' => false,
            'MON' => false,
            'TUE' => false,
            'WED' => false,
            'THU' => false,
            'FRI' => false,
            'SAT' => false,
        ];
        // setting day frequency
        foreach ($tutorAvailabilities as $tutorAvailability){
            if($tutorAvailability->SUN == 1){$days_frequency['SUN'] = true;}
            if($tutorAvailability->MON == 1){$days_frequency['MON'] = true;}
            if($tutorAvailability->TUE == 1){$days_frequency['TUE'] = true;}
            if($tutorAvailability->WED == 1){$days_frequency['WED'] = true;}
            if($tutorAvailability->THU == 1){$days_frequency['THU'] = true;}
            if($tutorAvailability->FRI == 1){$days_frequency['FRI'] = true;}
            if($tutorAvailability->SAT == 1){$days_frequency['SAT'] = true;}
        }

        // getting start_time and end_time of days
        foreach ($days_frequency as $day => $value){
            if($value == true){
                $times = [];
                $timings = TutorAvailability::select('start_time','end_time')->where([
                    'tutor_profile_id' => $this->id,
                    $day => 1
                ])->get();
                /*foreach ($timings as $timing){
                    $times[] = $timing->start_time . ' - ' . $timing->end_time;
                }*/

               //$day_wise_weekly_availabilities[] = [$day, $times];
               $day_wise_weekly_availabilities[$day] = $timings;
            }
        }

        return $day_wise_weekly_availabilities;
    }


    /*
     * Check either day is on or off from
     * if on than find the date and return
     * else leave the date
     * */
    public function tutor_availability_dates(){
        $tutorAvailabilities = $this->tutor_availabilities;
        $dates = [];
        $days_frequency = [
            'SUN' => false,
            'MON' => false,
            'TUE' => false,
            'WED' => false,
            'THU' => false,
            'FRI' => false,
            'SAT' => false,
        ];

        // true the frequency of available days
        foreach ($tutorAvailabilities as $tutorAvailability){
            if($tutorAvailability->SUN == 1){$days_frequency['SUN'] = true;}
            if($tutorAvailability->MON == 1){$days_frequency['MON'] = true;}
            if($tutorAvailability->TUE == 1){$days_frequency['TUE'] = true;}
            if($tutorAvailability->WED == 1){$days_frequency['WED'] = true;}
            if($tutorAvailability->THU == 1){$days_frequency['THU'] = true;}
            if($tutorAvailability->FRI == 1){$days_frequency['FRI'] = true;}
            if($tutorAvailability->SAT == 1){$days_frequency['SAT'] = true;}
        }

        foreach ($days_frequency as $day => $value){
            if($value == true){
                switch ($day){
                    case "SUN" : {
                        $dates[] = Carbon::parse('this sunday')->toDateString();
                    } break;
                    case "MON" : {
                        $dates[] = Carbon::parse('this monday')->toDateString();
                    } break;
                    case "TUE" : {
                        $dates[] = Carbon::parse('this tuesday')->toDateString();
                    } break;
                    case "WED" : {
                        $dates[] = Carbon::parse('this wednesday')->toDateString();
                    } break;
                    case "THU" : {
                        $dates[] = Carbon::parse('this thursday')->toDateString();
                    } break;
                    case "FRI" : {
                        $dates[] = Carbon::parse('this friday')->toDateString();
                    } break;
                    case "SAT" : {
                        $dates[] = Carbon::parse('this saturday')->toDateString();
                    } break;
                }
            }
        }

        return $dates;
    }

    /*
     * All Available Slots from Availabilities
     * one slots is of 15 minutes
     * (10:00 AM - 11:00 AM)
     *  - slots(10:00 AM - 10:15 AM, 10:15 AM - 10:30 AM, 10:30 AM - 10:45 AM, 10:45 AM - 11:00 AM)
     * */
    public function all_availabilities_slots_on_date($date, $duration){

        // find  the day of date - XXX(SUN,MUN ...)
        $day = date('D', strtotime($date)); // string 'Thu' (length=3), for textual representation user 'l' modifier you will get string 'Thursday' (length=8)
        $day = strtoupper($day);

        /*
        * Tutor profile id and the active day
        * */
        $tutor_availabilities = TutorAvailability::where([
            'tutor_profile_id' => $this->id,
            $day => 1
        ])->get();

        // if tutor availabilities are > 0'
        if($tutor_availabilities->count() > 0){
            foreach ($tutor_availabilities as $tutor_availability){
                $start_time =  $tutor_availability->start_time;
                $end_time =  $tutor_availability->end_time;

                // https://stackoverflow.com/questions/31849334/php-carbon-get-all-dates-between-date-range
                // https://carbon.nesbot.com/docs/
                Carbon::macro('range', function ($start, $end, $date, $duration){
                    return new Collection(new DatePeriod(new \DateTime($date. ' ' . $start), new DateInterval(''.ReservationCommonHelper::find_interval_spec($duration)),  new \DateTime($date. ' ' . $end)));
//                    return new Collection(new DatePeriod(new \DateTime($start), new DateInterval('PT15M'), new \DateTime($end)));
                });
                foreach (Carbon::range($start_time, $end_time, $date, $duration) as $slots){
                    $all_slots[] = [
                        'date' => $slots->format('d-m-y'),
                        'slot' => $slots->format('H:i'),
                        'slot with meridian' => $slots->format('g:i A')
                    ] ;
                }
/*                $all_slots[] = [
                    'date' => $date,
                    'slot' => $end_time,
                    'slow with meridian' => (new \DateTime($end_time))->format('g:i A')
                ];*/
            }
            return $all_slots;
        }else{
            return 0; // not available
        }
    }

    /**
     * Define relation for Tutor Profile with Tutor
     */
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }

    /*
 * Define relation for Tutor with tutor interest
 *
 * **/
    public function tutor_interests(){
        return $this->hasMany(TutorInterest::class, 'tutor_profile_id', 'id');
    }

    /*
     * Define relation for Tutor with tutor language
     *
     * **/
    public function tutor_languages(){
        return $this->hasMany(TutorLanguage::class, 'tutor_profile_id', 'id');
    }

    /*
     * Define relation for Tutor with tutor specialization
     *
     * **/
    public function tutor_specializations(){
        return $this->hasMany(TutorSpecialization::class, 'tutor_profile_id', 'id');
    }

    /*
     * Define relation for Tutor with tutor tutoring style
     *
     * **/
    public function tutor_tutoring_styles(){
        return $this->hasMany(TutorTutoringStyle::class, 'tutor_profile_id', 'id');
    }

    /*
     * Define relation for Tutor with tutor Tutor Certification
     *
     * **/
    public function tutor_certifications(){
        return $this->hasMany(TutorCertification::class, 'tutor_profile_id', 'id');
    }

    /*
     * Define relation for Tutor with Tutor Rating
     *
     * **/
    public function tutor_ratings(){
        return $this->hasMany(TutorRating::class, 'tutor_profile_id', 'id');
    }

    /*
     * Define relation for Tutor with Tutor Availability
     *
     * **/
    public function tutor_availabilities(){
        return $this->hasMany(TutorAvailability::class, 'tutor_profile_id', 'id');
    }

    /*
    * Define relation for Tutor Profile with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
