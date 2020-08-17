<?php

namespace App\Http\Controllers;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SalaryController extends Controller
{
    function index()
    {
        // ToDO add this to constructor
        Carbon::setWeekendDays([
            Carbon::FRIDAY,
            Carbon::SATURDAY
        ]);

        $yearArray = array();

        $now = Carbon::now();
        $currentMonth = $now->format('m');

        while ($currentMonth <= 12) {
            $lastDayOfTheMonth = $now->endOfMonth();


            //ToDo create function getPaymentWeekDay
            if ($lastDayOfTheMonth->isWeekday()) {
                $salariesPaymentDay = $lastDayOfTheMonth;
            } else {
                $salariesPaymentDay = $lastDayOfTheMonth->previousWeekday();
            }


            //	        print $now->englishMonth . " -- ";
            $day15 = new Carbon("15 " . $now->englishMonth);

            if ($day15->isWeekday()) {
                $bonusPaymentDay = $day15;
            } else {
                $bonusPaymentDay = $day15->previousWeekday();
            }

            $salariesTotal = Employee::all()->pluck('base_salary')->sum();
            $bonusTotal = Employee::all()->sum('bonus_salary');

            $monthlySalaries = [];
            $monthlySalaries['Month'] = $now->englishMonth;
            $monthlySalaries['Salaries_payment_day'] = $salariesPaymentDay->day;
            $monthlySalaries['Bonus_payment_day'] = $bonusPaymentDay->day;
            $monthlySalaries['Salaries_total'] = round($salariesTotal, 2);
            $monthlySalaries['Bonus_total'] = round($bonusTotal, 2);
            $monthlySalaries['Payments_total'] = round($salariesTotal + $bonusTotal, 2);

            $now->addMonthNoOverflow();
            $currentMonth++;
            $yearArray[] = $monthlySalaries;
        }
        $msg = array('response' => $yearArray);

        return $msg;
    }


}