<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait ModelTrait
{
    /**
    * Process export quality data
    *
    * @param array $headPropertyMapper
    * @param array|LengthAwarePaginator $rawData
    * @return array $data
    */
    public function dataProcessor($headPropertyMapper, $rawData)
    {
        $data = [];

        if ($rawData instanceof LengthAwarePaginator) {
            $rawData = $rawData->toArray();

            $rawData = isset($rawData['data']) ? $rawData['data']: [];
        }

        if (!is_array($rawData)) {
            return $data;
        }

        $properties = array_keys($headPropertyMapper);

        foreach ($rawData as $value) {
            $row = [];

            if (isset($value['daily_report']) && is_array($value['daily_report'])) {
                $dailyReport = $value['daily_report'];
                unset($value['daily_report']);

                $total = 0;

                foreach ($dailyReport as $item) { 
                    $dt = date('n/j', strtotime($item['report_date']));
                    $value[$dt] = $item['daily_amount'];

                    $total += $item['daily_amount'];
                }

                $value['total'] = $total;
            }

            foreach ($properties as $key => $property) {
                $row[$key] = isset($value[$property]) ? $value[$property] : '-';
            }

            array_push($data, $row);
        }

        return $data;
    }
}