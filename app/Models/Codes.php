<?php

namespace App\Models;

use App\Jobs\deleteCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Codes extends Model
{
    use HasFactory;

//    protected $table= ['codes'];
//    protected $fillable = ['code'];

    public function getCode($email)
    {
        if ($this->where('email', $email)->first() == null) {
            $code = new Codes();
            $code->code = rand(10000, 99999);
            $code->email = $email;
            $code->save();
            $job = new deleteCode($email);
//        $job = deleteCode::create($code->id);
            deleteCode::dispatch($job)->delay(Carbon::now()->addMinutes(5));
            Log::error('tratra3');
            return $code;
        } else {
            return false;
        }
    }

    public function deleteCode($email)
    {
//        dd($this->where('email',$email)->first());
        Log::info($email);
        $code_id = $this->where('email', $email)->first()->id;

        $this->find($code_id)->delete();
    }

}
/*метод гетпродукт для юзера
прдварительный расчет с мин данными
почтовый сервис

метод оплаты
получение номера полиса для qr
*/
//Авториз емаил пароль в хеше саксес ок и токен, эрор
//метод востановления пароля - ?
//рега емаил пароль в хеше, телефон необяз,
//метод отправки кода принмает маил и отправляет код
//при регистрации емаил пароль код и запись в бд ретурн
//                                    статус - уже существ, неверный код
//                                    саксес токен
//                                    эрор код неверный, невалидность
//гетполисилист - массив[
//    название продукта
//    фами имя
//    даты от идо действия
//    номер полиса
//    ] - по токену
//сендполиси - номер полиса и емаил из нашей базы
//
//
//obtainPolicy - вход[
//    список необходимых для оформления полиса данных
//    трансилтерация()
//
//    ]
//ретурн - номер полиса страх сум  страх премия ?терриория страхования? ссылка на правила страхования
//
//метод хелп навход емаил текст ретурн ок смс в бота Хелп
