<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
{
    // دالة لتحويل الأرقام الهندية
    public static function convertToHindiNumbers($number)
    {
        $hindiNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($englishNumbers, $hindiNumbers, $number);
    }

    /**
     * تحويل التاريخ إلى الأرقام الهندية.
     */
    public static function convertDateToHindiNumbers($date)
    {
        // تحويل التاريخ إلى أرقام هندية
        return self::convertToHindiNumbers($date);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'national_id' => self::convertToHindiNumbers($this->national_id),
            'from_date' => self::convertDateToHindiNumbers($this->from_date),
            'to_date' => self::convertDateToHindiNumbers($this->to_date),
            'hours' => $this->hours,
            'created_at' => self::convertDateToHindiNumbers($this->created_at->format('Y-m-d H:i:s')),
        ];
    }
}
