<?php

use PHPHtmlParser\Dom;

class RealtByParser
{


    public function parse(?int $rooms): array
    {
        $dom = new Dom;

        $roomsAmount = null;
        switch ($rooms) {
            case 1:
                $dom->loadFromUrl('https://realt.by/rent/flat-for-day/1k/');
                $roomsAmount = 1;
                break;
            case 2:
                $dom->loadFromUrl('https://realt.by/rent/flat-for-day/2k/');
                $roomsAmount = 2;
                break;
            case 3:
                $dom->loadFromUrl('https://realt.by/rent/flat-for-day/3k/');
                $roomsAmount = 3;
                break;
            case 4:
                $dom->loadFromUrl('https://realt.by/rent/flat-for-day/4k/');
                $roomsAmount = 4;
                break;
            default:
                $dom->loadFromUrl('https://realt.by/rent/flat-for-day/');
                break;
        }

        $houses = $dom->find('.bd-item');

        return $houses;
    }

    public function saveHousesToDb(array $houses, ?int $roomsAmount): void
    {
        foreach ($houses as $house) {

            $newHouse = new \App\Houses();

            $newHouse->title = $house->find('.title/.media/.media-body/a')->text;
            $newHouse->image_link = $house->find('.bd-item-left/.bd-item-left-top/img')->getAttribute('data-original');
            $newHouse->uploaded = $house->find('.bd-item-right/.bd-item-right-top/.fl')[2]->text;
            $newHouse->contacts = $house->find('.bd-item-right-bottom-left/.mb0')->text;
            $newHouse->description = $house->find('.bd-item-right-center/p')[1]->text;
            $newHouse->rooms = $roomsAmount;

            $pricePerDay = $house->find('.price-byr')->text;
            $newHouse->price_per_day = preg_replace("/[^0-9]/", '', $pricePerDay);

            $newHouse->save();
        }
    }
}
