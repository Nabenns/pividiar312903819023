<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    //
    public function calculator()
    {
        return view('tools.calculator');
    }

    public function calendar()
    {
        // Cache data for 1 hour to avoid hitting the server too often
        $events = \Illuminate\Support\Facades\Cache::remember('forex_calendar_v2', 3600, function () {
            try {
                $xmlString = file_get_contents('https://nfs.faireconomy.media/ff_calendar_thisweek.xml');
                $xml = simplexml_load_string($xmlString);
                
                $events = [];
                foreach ($xml->event as $event) {
                    $events[] = [
                        'title' => (string)$event->title,
                        'country' => (string)$event->country,
                        'date' => (string)$event->date,
                        'time' => (string)$event->time,
                        'impact' => (string)$event->impact,
                        'forecast' => (string)$event->forecast,
                        'previous' => (string)$event->previous,
                        'actual' => (string)$event->actual,
                    ];
                }
                
                return $events;
            } catch (\Exception $e) {
                return [];
            }
        });

        return view('tools.calendar', compact('events'));
    }
}
