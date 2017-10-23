<?php

namespace App\Model;

class Ward
{

    /**
     * Given the name of a councillor or the mayor, return the ward. In the case of the mayor we set his ward as "Mayor"
     *
     * @param string $council_member
     * @return string
     */
    public static function getWardFor($council_member)
    {
        $map = [
            'A. Knack - Councillor' => 1,
            'B. Esslinger - Councillor' => 2,
            'D. Loken - Councillor' => 3,
            'E. Gibbons - Councillor' => 4,
            'M. Oshry - Councillor' => 5,
            'S. McKeen - Councillor' => 6,
            'T. Caterina - Councillor' => 7,
            'B. Henderson - Councillor' => 8,
            'B. Anderson - Councillor' => 9,
            'M. Walters - Councillor' => 10,
            'M. Nickel - Councillor' => 11,
            'A. Sohi - Councillor' => 12,
            'M. Banga - Councillor' => 12,
            'D. Iveson - Mayor' => "Mayor"
        ];

        if (!array_key_exists($council_member, $map)) {
            return "Unknown";
        }

        return $map[$council_member];
    }

}
