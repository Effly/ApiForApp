<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policies extends Model
{
    use HasFactory;

    public function fetchPolicies($user_id)
    {
        return $this->where('user_id', $user_id)->get();
    }

    public function savePolicy($data,$user_id)
    {
        $data['number'] = $this->getCounter();
        $policy = new Policies();
        $policy->policy_data = serialize($data);
        $policy->user_id = $user_id;
        $save = $policy->save();
        if ($save)  return [

            'policy_number' => $data['number'],
            'policy_series' => 'ser.',
            'ins_sum' => ins_sum,
            'ins_premium' => ins_premium,
            'rules_link' => 'url',
        ];
        else return false;
    }
    public function getCounter()
    {
        $file_counter = 'counter.dat';

        // Читаем текущее значение счетчика
        if (file_exists($file_counter)) {
            $fp = fopen($file_counter, "r");
            $counter = fread($fp, filesize($file_counter));
            fclose($fp);
        } else {
            $counter = 000000000001;
        }
        // Увеличиваем счетчик на единицу
        $counter++;
        // Сохраняем обновленное значение счетчика
        $fp = fopen($file_counter, "w");
        fwrite($fp, $counter);
        fclose($fp);
        return $counter;
    }
}
