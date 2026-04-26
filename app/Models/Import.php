<?php


namespace App\Models;


use Maatwebsite\Excel\Concerns\ToModel;

class Import implements ToModel
{
    public function model(array $row)
    {
        return new Question([
            'pertanyaan' => $row[0],
            'opsi_a' => $row[1],
            'opsi_b' => $row[2],
            'opsi_c' => $row[3],
            'opsi_d' => $row[4],
            'opsi_e' => $row[5],
            'jawaban' => strtolower($row[6]),
            'durasi' => $row[7],
            'id_mapel' => $row[8],
        ]);
    }
}