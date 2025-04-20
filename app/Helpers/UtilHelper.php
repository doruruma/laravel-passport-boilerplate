<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class UtilHelper
{
    public static function formatQty($qty)
    {
        return fmod($qty, 1) == 0.00 ? intVal($qty) : number_format($qty, 2);
    }

    public static function parseStringToNumber($str)
    {
        return str_replace([',', '.'], ['', ''], $str);
    }

    public static function formatCurrency($currency, $separator = '.')
    {
        return number_format(intval($currency), 0, '.', $separator);
    }

    public static function formatDateTime($dateTime, $format = 'd-m-Y H:i')
    {
        if (!$dateTime)
            return null;
        return Carbon::parse($dateTime)->locale('id')->format($format);
    }

    public static function validateDateRange($startDate, $endDate, $limit = 30)
    {
        if (Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) > $limit)
            return response()->json(['message' => 'Jangka waktu maksimal 1 bulan'], 500);
        return null;
    }

    public static function getOrPaginate(Request $request, $data)
    {
        if ($request->filled('page'))
            return $data->paginate(Constant::$PAGE_SIZE);
        else
            return $data->get();
    }

    public static function getTimePeriodFilter($timePeriod)
    {
        $result = null;
        switch ($timePeriod) {
            case 0:
                $result = [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];
                break;
            case 1:
                $result = [Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay()];
                break;
            case 2:
                $result = [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->endOfDay()];
                break;
            case 3:
                $result = [Carbon::now()->firstOfMonth(), Carbon::now()->endOfDay()];
                break;
            case 4:
                $result = [Carbon::now()->subMonth(1)->firstOfMonth(), Carbon::now()->subMonth(1)->lastOfMonth()];
                break;
            case 5:
                $result = [Carbon::now()->firstOfYear(), Carbon::now()->endOfYear()];
                break;
            default:
                break;
        }
        return $result;
    }
}
