<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
{
    // Function to convert English numbers to Hindi numbers
    public static function convertToHindiNumbers($number)
    {
        $hindiNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($englishNumbers, $hindiNumbers, $number);
    }

    // Function to convert date to Hindi numbers
    public static function convertDateToHindiNumbers($date)
    {
        return self::convertToHindiNumbers($date);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $fromDate = new \DateTime($this->from_date);
        $toDate = new \DateTime($this->to_date); 
        return [
            'id' => $this->id,
            'name' => $this->name,
            'national_id' => self::convertToHindiNumbers($this->national_id),
            'gender' => $this->gender,
            'phone_number' =>self::convertToHindiNumbers($this->phone_number) ,
            'city' => $this->city,
            'accept_policy' => $this->accept_policy,
            'transferred_by' => $this->transferred_by,
            'other' => $this->other,
            'from_date' => self::convertDateToHindiNumbers($fromDate->format('d-m-Y')),
            'to_date' => self::convertDateToHindiNumbers($toDate->format('d-m-Y')),    
            'hours' =>  self::convertDateToHindiNumbers($this->hours),
            'created_at' => self::convertDateToHindiNumbers($this->created_at->format('d-m-Y H:i:s')),
        ];
    }
}
