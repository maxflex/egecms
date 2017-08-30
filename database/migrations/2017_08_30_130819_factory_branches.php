<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FactoryBranches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('factory')->create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('weight')->unsigned()->comment('вес линии');
            $table->string('code', 3);
            $table->string('short', 3);
            $table->string('full');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('color');
            $table->string('lat');
            $table->string('lng');
            $table->string('time');
        });

        \DB::connection('factory')->table('branches')->insert([
            [
                'id'        => 1,
                'code'      => 'TRG',
                'short'     => 'ТУР',
                'full'      => 'Тургеневская',
                'name'      => 'ЕГЭ-Центр-Тургеневская',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Мясницкая, д. 40, стр. 1',
                'color'     => '#FBAA33',
                'lat'       => '55.76678',
                'lng'       => '37.64141',
                'weight'    => 1,
            ],
            [
                'id'        => 2,
                'code'      => 'PVN',
                'short'     => 'ВЕР',
                'full'      => 'Проспект Вернадского',
                'name'      => 'ЕГЭ-Центр-Вернадского',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'проспект Вернадского д. 41с3',
                'color'     => '#EF1E25',
                'lat'       => '55.673982',
                'lng'       => '37.504044',
                'weight'    => 2,
            ],
            [
                'id'        => 3,
                'code'      => 'BGT',
                'short'     => 'БАГ',
                'full'      => 'Багратионовская',
                'name'      => 'ЕГЭ-Центр-Багратионовская',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Барклая, д. 13, стр. 2',
                'color'     => '#019EE0',
                'lat'       => '55.744683',
                'lng'       => '37.494297',
                'weight'    => 3,
            ],
            [
                'id'        => 5,
                'code'      => 'IZM',
                'short'     => 'ИЗМ',
                'full'      => 'Багратионовская',
                'name'      => 'ЕГЭ-Центр-Измайловская',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. 1-я Парковая, дом 7',
                'color'     => '#0252A2',
                'lat'       => '55.789345',
                'lng'       => '37.777526',
                'weight'    => 4,
            ],
            [
                'id'        => 6,
                'code'      => 'OPL',
                'short'     => 'ОКТ',
                'full'      => 'Октябрьское поле',
                'name'      => 'ЕГЭ-Центр-Октябрьское поле',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Маршала Бирюзова, дом 1, корпус 1',
                'color'     => '#B61D8E',
                'lat'       => '55.789709',
                'lng'       => '37.498896',
                'weight'    => 5,
            ],
            [
                'id'        => 7,
                'code'      => 'RPT',
                'short'     => 'РЯЗ',
                'full'      => 'Рязанский Проспект',
                'name'      => 'ЕГЭ-Центр-Рязанский Проспект',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. 1-я Новокузьминская, дом 19',
                'color'     => '#B61D8E',
                'lat'       => '55.714663',
                'lng'       => '37.790893',
                'weight'    => 5,
            ],
            [
                'id'        => 8,
                'code'      => 'SKL',
                'short'     => 'СКЛ',
                'full'      => 'Сокол',
                'name'      => 'ЕГЭ-Центр-Сокол',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'Ленинградский проспект, 68с24',
                'color'     => '#029A55',
                'lat'       => '55.804379',
                'lng'       => '37.524989',
                'weight'    => 6,
            ],
            [
                'id'        => 9,
                'code'      => 'ORH',
                'short'     => 'ОРЕ',
                'full'      => 'Орехово',
                'name'      => 'ЕГЭ-Центр-Орехово',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Домодедовская, дом 20, стр. 1',
                'color'     => '#029A55',
                'lat'       => '55.612853',
                'lng'       => '37.702113',
                'weight'    => 6,
            ],
            [
                'id'        => 11,
                'code'      => 'ANN',
                'short'     => 'АНН',
                'full'      => 'Аннино',
                'name'      => 'ЕГЭ-Центр-Аннино',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Кирпичные выемки 2к1',
                'color'     => '#ACADAF',
                'lat'       => '55.586894',
                'lng'       => '37.601492',
                'weight'    => 8,
            ],
            [
                'id'        => 12,
                'code'      => 'PER',
                'short'     => 'АНН',
                'full'      => 'Перово',
                'name'      => 'ЕГЭ-Центр-Перово',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'Зеленый проспект, дом 20',
                'color'     => '#FFD803',
                'lat'       => '55.750038',
                'lng'       => '37.787192',
                'weight'    => 9,
            ],
            [
                'id'        => 17,
                'code'      => 'BEL',
                'short'     => 'БЕЛ',
                'full'      => 'Беляево',
                'name'      => 'ЕГЭ-Центр-Беляево',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Профсоюзная, дом 93А',
                'color'     => '#C07911',
                'lat'       => '55.640048',
                'lng'       => '37.525458',
                'weight'    => 1,
            ],
            [
                'id'        => 14,
                'code'      => 'BRT',
                'short'     => 'БРА',
                'full'      => 'Братиславская',
                'name'      => 'ЕГЭ-Центр-Братиславская',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Братиславская, дом 6',
                'color'     => '#B1D332',
                'lat'       => '55.664055',
                'lng'       => '37.753245',
                'weight'    => 7,
            ],
            [
                'id'        => 15,
                'code'      => 'STR',
                'short'     => 'СТР',
                'full'      => 'Строгино',
                'name'      => 'ЕГЭ-Центр-Строгино',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'ул. Кулакова, дом 20, стр. 1а',
                'color'     => '#0252A2',
                'lat'       => '55.805469',
                'lng'       => '37.391899',
                'weight'    => 4,
            ],
            [
                'id'        => 16,
                'code'      => 'VLD',
                'short'     => 'ВЛА',
                'full'      => 'Владыкино',
                'name'      => 'ЕГЭ-Центр-Владыкино',
                'time'      => 'ПН-СБ 10:00-19:00',
                'phone'     => '+7 495 646-85-92',
                'address'   => 'Гостиничная улица, д. 3',
                'color'     => '#ACADAF',
                'lat'       => '55.842661',
                'lng'       => '37.579619',
                'weight'    => 8,
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('factory')->dropIfExists('branches');
    }
}
