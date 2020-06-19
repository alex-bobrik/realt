<?php
namespace App\Console\Commands;
use App\Http\Controllers\RealtByParser;
use Illuminate\Console\Command;
use PHPHtmlParser\Dom;

class ParseHouses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:houses {rooms}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse houses from realt.by';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rooms = $this->argument('rooms');

        if ($rooms > 4 || $rooms < 1) {
            $this->error("Error. Amount of rooms should be in range from 1 to 4.");
            return;
        }

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

        foreach ($houses as $house) {

            $newHouse = new \App\Houses();

            $newHouse->title = $house->find('.title/.media/.media-body/a')->text;
            $newHouse->image_link = $house->find('.bd-item-left/.bd-item-left-top/img')->getAttribute('data-original');
            $newHouse->contacts = $house->find('.bd-item-right-bottom-left/.mb0')->text;

            // If text is not in <p>
            try {
                $newHouse->description = $house->find('.bd-item-right-center/p')[1]->text;
            } catch (\ErrorException $e) {
                // Parsing in <li>
                $newHouse->description = $house->find('.bd-item-right-center/li')->text;
            }

            $newHouse->updated = $house->find('.bd-item-right/.bd-item-right-top/p.f11')[0]->text;
            $newHouse->rooms = $roomsAmount;

            $pricePerDay = $house->find('.price-byr')->text;
            $pricePerDayNumeric = preg_replace("/[^0-9]/", '', $pricePerDay);

            if (is_numeric($pricePerDayNumeric)) {
                $newHouse->price_per_day = $pricePerDayNumeric;
            } else {
                $newHouse->price_per_day = null;
            }

            $newHouse->save();
        }

        return;
    }
}
