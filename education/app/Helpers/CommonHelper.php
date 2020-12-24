<?php

namespace App\Helpers;

use App\Models\Users\Students\StudentBalance;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class CommonHelper
{
    /*
     * Generating Guzzle Request
     * */
    public static function generateGuzzlePostRequest($url, $body){
        $client = new Client(['headers' => [ 'Content-Type' => 'application/json']]);
        $res = $client->post(''.$url, ['body' => json_encode($body)]);
        return $res;
    }

    /*
     * Pusher
     * */
    public static function puhser(){
        $options = array(
            'cluster' => 'ap2',
            'encrypted' => true
        );
        $pusher = new Pusher(
            '6a46b90592aa1656faab',
            'b3a2e271569c7e4fc059',
            '488398',
            $options
        );

        return $pusher;
    }

    /*
     * Sales Report: criteria wise
     * daily: last 7 days record
     * weekly: last 4 weeks record
     * monthly: last 12 month record
     * quarterly: last year record in quarters
     * yearly: yearly record
     * dateWise: user will proved the date and hourly sales of the date will be returned
     * */
    /**
     * @param $params
     * @return array
     */
    public static function salesReport($params){
        $criteria = $params['criteria'];

        //for chart
        /*
         * daily: days[sun to sun]
         * weekly: 1,2,3,4
         * monthly: month [jan to dec]
         * quarterly: jan,april,aug,dec
         * yearly: 20XX...
         * dateWise: hours 1 to 24
         * */
        $xAxisDataCollection = collect();

        /*
         * hold the actual sales data
         * */
        $salesCollection = collect();

        /*
         * - will hold the detail data of sale
         * - will hold the objects of StudentBalances
         * */
        $salesDetailCollection = collect();

        /*
         * Hold the total amount of sale
         * */
        $totalOfSale = 0;

        /*
         * msg about sale
         * used in chart
         * */
        $msg = "";

       switch ($criteria){
             // last 7 days
            case 'daily': {
                /*
                 * Last week report
                 * startDay: the last day of week from today(LAST-FRI) - date 20
                 * endDay: day of today(THIS-FRI)- date 13
                 * */
//                $startDay = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d')-7,date('Y')));
                $w = date('Y-m-d H:i:s', strtotime("-1 week")); // one week ago
                $startDay = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m', strtotime($w)), date('d',strtotime($w)), date('Y',strtotime($w))));
                $endDay = date("Y-m-d H:i:s", mktime(23, 59, 59, date('m'), date('d'), date('Y')));

                //loop through each day of week to finding the day
//                for($loopDay = date('d',strtotime($startDay)); $loopDay <= date('d',strtotime($endDay)); $loopDay++){
                for($loopDate = $startDay; strtotime($loopDate) <= strtotime($endDay); $loopDate=date('Y-m-d H:i:s',strtotime("+1 day", strtotime($loopDate)))){

                    $loopDay = date('d',strtotime($loopDate));

                    // making the date
                    $date = '' . date('Y-m-d H:i:s', mktime(0,0,0,date('m', strtotime($loopDate)),$loopDay,date('Y',strtotime($loopDate))));
                    $endOfDate = '' . date('Y-m-d H:i:s', mktime(23,59,59,date('m',strtotime($loopDate)),$loopDay,date('Y',strtotime($loopDate))));

                    // find  the day of date - XXX(SUN,MUN ...)
                    $day = date('D', strtotime($date)); // string 'Thu' (length=3)
                    $day = strtoupper($day);
                    $xAxisDataCollection->push("'".$day."'");

                    /*
                    * weeklySales:
                    * student subscription of week will be displayed
                    * */
                    $dayWiseSale = 0;
                    $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$date,$endOfDate])->get();
                    if($studentBalances->count() > 0){
                        foreach ($studentBalances as $studentBalance){
                            $dayWiseSale += $studentBalance->purchased_amount; // sold amount
                            $salesDetailCollection->push($studentBalance); // transaction in detail
                            $totalOfSale += $studentBalance->purchased_amount;
                        }
                    }else{
                        $dayWiseSale = 0;
                    }
                    $salesCollection->push($dayWiseSale);
                }

                $msg = "Calculated in last 7 days";
            } break;
            case 'weekly': {

                // loop through each week of this month
                for($loopWeek = 1; $loopWeek <= 4; $loopWeek++){

                    $startDayOfWeek = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),($loopWeek > 1)? $loopWeek * 7 - 7 : 1,date('Y'))); // 1 date of this month
                        // month and year
                        if($loopWeek < 4){
                            $m = date('m');
                        }else{
                            // last week
                            $m = date('m') + 1; // next month
                        }
                        if($m < 12){
                            $y = date('Y');
                        }
                        else{
                            // DEC
                            $y = date('Y') + 1; // next year
                        }
                    if($loopWeek < 4) {
                        $endDayOfWeek = date('Y-m-d H:i:s',
                            mktime(23,59,59, $m, ($loopWeek < 4) ? $loopWeek * 7 : 1, $y)); // 1 date of this month[end day of last week is the fist day of next month]
                    }else{
                        $endDayOfWeek = date('Y-m-d H:i:s',
                            mktime(0,0,0, $m,1, $y)); // 1 date of this month[end day of last week is the fist day of next month]
                    }


                    // adding week number [1,2,3,4]
                    $xAxisDataCollection->push("'".$loopWeek."'");

                    /*
                    * weeklySales:
                    * student subscription of week will be displayed
                    * */
                    $weekWiseSale = 0;
                    $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$startDayOfWeek,$endDayOfWeek])->get();
                    if($studentBalances->count() > 0){
                        foreach ($studentBalances as $studentBalance){
                            $weekWiseSale += $studentBalance->purchased_amount; // sold amount
                            $salesDetailCollection->push($studentBalance); // transaction in detail
                            $totalOfSale += $studentBalance->purchased_amount;
                        }
                    }else{
                        $weekWiseSale = 0;
                    }
                    $salesCollection->push($weekWiseSale);
                }

                $msg = "Calculated in this month ";
            } break;
            case 'monthly': {
                /*
                 * Jul of 2018 - endMonth
                 * Jul of 2017 - startMonth
                 *
                 * */

                $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), 1,date('Y')-1)); // first day of this month of last year
                $endDate = date("Y-m-d H:i:s", mktime(23, 59, 59, date('m'), date('d'), date('Y'))); // today

                $startMonth = date('m' , strtotime($startDate));
                $startYear = date('Y' , strtotime($startDate));

                $endMonth = date('m' , strtotime($endDate));
                $endYear = date('Y' , strtotime($endDate));

                $loopStop = 0;
                for($loopMonth = $startMonth; $loopStop < 1; $loopMonth++){
                    if($loopMonth > 12){
                        $loopMonth = 1;
                        $startYear++; // 2017 + 1 = 2018
                    }

                    // making the month
                    $startOfMonth = '' . date('Y-m-d H:i:s', mktime(0,0,0,$loopMonth,1,$startYear));
                    $endOfMonth = '' . date('Y-m-d H:i:s', mktime(23,59,59,$loopMonth+1,1,$startYear));

                    // find  the month - XXX(JAN,FEB ...)
                    $month = date('M', strtotime($startOfMonth)); // string 'JAN' (length=3)
                    $month = strtoupper($month);
                    $xAxisDataCollection->push("'".$month."'");

                    $monthWiseSale = 0;
                    $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$startOfMonth,$endOfMonth])->get();
                    if($studentBalances->count() > 0){
                        foreach ($studentBalances as $studentBalance){
                            $monthWiseSale += $studentBalance->purchased_amount; // sold amount
                            $salesDetailCollection->push($studentBalance); // transaction in detail
                            $totalOfSale += $studentBalance->purchased_amount;
                        }
                    }else{
                        $monthWiseSale = 0;
                    }
                    $salesCollection->push($monthWiseSale);

                    if($loopMonth == $endMonth){
                        if($startYear == $endYear){
                            $loopStop = 1;
                        }
                    }
                }

                $msg = "Calculated in last 12 months";
            } break;
            case 'quarterly': {
                /*
                 * 1 : JAN to MAR
                 * 2 : APR to JUN
                 * 3 : JUL to SEP
                 * 4 : OCT to DEC
                 * -----------------------
                 * - same year:
                 *      startDate: 1 JAN
                 *      endDate: 31 DEC
                 * -----------------------
                 * */

                for($loopMonth = 1; $loopMonth <= 12; $loopMonth+=3)
                {
                    /*
                     * making the month's in quarter
                     * 1 JAN 12:00:00 AM to 1 APR 12:00:00 AM
                     * if: SEP to DEC
                     * then: 1 SEP 12:00:00 AM of this year(2018) to 1 JAN 12:00:00 AM of next year(2019)
                     * because: the record of 1 SEP to 31 DEC will be the between of 1 SEP to 1 JAN of next year
                     */
                    $startQuarterMonth = '' . date('Y-m-d H:i:s', mktime(0,0,0,$loopMonth,1, date('Y'))); // 1 JAN 12:00:00 AM
                    $endQuarterMonth = '' . date('Y-m-d H:i:s',
                            mktime(0,0,0,($loopMonth+3 <= 12 ? $loopMonth+3 : 1),1, ($loopMonth+3 <= 12 ? date('Y') : date('Y')+1))); // APR 12:00:00 AM

                    // find  the month - XXX(JAN, APR ...)
                    $month = date('M', strtotime($startQuarterMonth)); // string 'JAN' (length=3)
                    $month = strtoupper($month);

                    $eMonth = date('M', strtotime(date('Y-m-d H:i:s', mktime(0,0,0,date('m', strtotime($endQuarterMonth))-1,1,date('Y'))))); // string 'JAN' (length=3)
                    $eMonth = strtoupper($eMonth);
                    $xAxisDataCollection->push("'".$month."-".$eMonth."'");

                    $quarterWiseSale = 0;
                    $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$startQuarterMonth,$endQuarterMonth])->get();
                    if($studentBalances->count() > 0){
                        foreach ($studentBalances as $studentBalance){
                            $quarterWiseSale += $studentBalance->purchased_amount; // sold amount
                            $salesDetailCollection->push($studentBalance); // transaction in detail
                            $totalOfSale += $studentBalance->purchased_amount;
                        }
                    }else{
                        $quarterWiseSale = 0;
                    }
                    $salesCollection->push($quarterWiseSale);
                }
                $msg = "Calculated of this year";
            } break;
            case 'yearly': {
                $firstSB = StudentBalance::limit(1)->first(); // first row
                $yearOfFirstSB = date('Y', strtotime($firstSB->created_at));

                $lastSB = StudentBalance::orderBy('id','DESC')->limit(1)->first(); // last row
                $yearOfEndSB = date('Y', strtotime($lastSB->created_at));

                // loop through the years
                for($loopYear = $yearOfFirstSB-1; $loopYear <= $yearOfEndSB+1; $loopYear++){
                    // adding years
                    $xAxisDataCollection->push("'".$loopYear."'");

                    // making dates
                    $startOfYear = '' . date('Y-m-d H:i:s', mktime(0,0,0,1,1,$loopYear)); // 1 JAN of loop year
                    $endOfYear = '' . date('Y-m-d H:i:s', mktime(23,59,59,12,31,$loopYear)); // 31 DEC of loop year

                    $yearWiseSale = 0;
                    $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$startOfYear,$endOfYear])->get();
                    if($studentBalances->count() > 0){
                        foreach ($studentBalances as $studentBalance){
                            $yearWiseSale += $studentBalance->purchased_amount; // sold amount
                            $salesDetailCollection->push($studentBalance); // transaction in detail
                            $totalOfSale += $studentBalance->purchased_amount;
                        }
                    }else{
                        $yearWiseSale = 0;
                    }
                    $salesCollection->push($yearWiseSale);
                }
                $msg = "Calculation of all years";
            } break;
            case 'on_date': {
                $theDate = $params['date'];
                $dayOfDate = date('d', strtotime($theDate));
                $monthOfDate = date('m', strtotime($theDate));
                $yearOfDate = date('Y', strtotime($theDate));

                // loop through the hours of date [ 0 to 24]
                for($loopHour = 0; $loopHour < 24; $loopHour++){

                    $startHour = date('Y-m-d H:i:s', mktime($loopHour,0,0,$monthOfDate,$dayOfDate,$yearOfDate));
                    $endHour = date('Y-m-d H:i:s', mktime($loopHour,59,59,$monthOfDate,$dayOfDate,$yearOfDate));

                    // 0,1,2 - 23 ...
                    $xAxisDataCollection->push("'".$loopHour."'");

                    $hourWiseSale = 0;
                    $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$startHour,$endHour])->get();
                    if($studentBalances->count() > 0){
                        foreach ($studentBalances as $studentBalance){
                            $hourWiseSale += $studentBalance->purchased_amount; // sold amount
                            $salesDetailCollection->push($studentBalance); // transaction in detail
                            $totalOfSale += $studentBalance->purchased_amount;
                        }
                    }else{
                        $hourWiseSale = 0;
                    }
                    $salesCollection->push($hourWiseSale);
                }

                $msg = "Calculated on date " . $theDate;
            } break;
       }
        //
        return ['xAxisData' => $xAxisDataCollection,'sales' => $salesCollection , 'salesDetail' => $salesDetailCollection, 'totalAmount' => $totalOfSale, 'msg' => $msg];
     }
}