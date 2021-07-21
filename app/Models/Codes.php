<?php

namespace App\Models;

use App\Jobs\deleteCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Codes extends Model
{
    use HasFactory;
//    protected $table= ['codes'];
//    protected $fillable = ['code'];

    public function getCode(){
        $code = new Codes();
        $code->code = rand(10000,99999);
        $code->save();
        $id = $code->id;
        Log::error('tratra');
        $job = new deleteCode($id);

        Log::error('tratra2');
//        $job = deleteCode::create($code->id);
        deleteCode::dispatch($job)->delay(Carbon::now()->addMinutes(1));
        Log::error('tratra3');
        return $code;
    }
    public function deleteCode($id){
        $this->find($id)->delete();
    }
    public function deleteUsedCode(){

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
