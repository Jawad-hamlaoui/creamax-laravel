<?php

namespace App\Http\Controllers;

use App\Enums\RendezVousStatus;
use App\Models\RendezVous;
use App\Models\Setting;
use Illuminate\Http\Response;

class CalendarFeedController extends Controller
{
    public function show(string $token): Response
    {
        $settings = Setting::current();

        abort_unless(filled($settings->calendar_token) && hash_equals($settings->calendar_token, $token), 404);

        $rendezVous = RendezVous::query()
            ->where('status', RendezVousStatus::Valide)
            ->whereNotNull('date_heure')
            ->with('client')
            ->orderBy('date_heure')
            ->get();

        return response($this->buildIcs($rendezVous), 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'inline; filename="creamax-rendez-vous.ics"',
        ]);
    }

    private function buildIcs($rendezVousList): string
    {
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Créa\'Max//Rendez-vous//FR',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'X-WR-CALNAME:Créa\'Max — Rendez-vous',
            'REFRESH-INTERVAL;VALUE=DURATION:PT1H',
        ];

        foreach ($rendezVousList as $rendezVous) {
            $start = $rendezVous->date_heure->clone()->setTimezone('UTC');
            $end = $start->clone()->addHour();
            $client = $rendezVous->client;
            $summary = 'RDV — '.($client ? "{$client->prenom} {$client->nom}" : 'Client');

            $lines[] = 'BEGIN:VEVENT';
            $lines[] = 'UID:rendez-vous-'.$rendezVous->id.'@'.parse_url(config('app.url'), PHP_URL_HOST);
            $lines[] = 'DTSTAMP:'.now()->setTimezone('UTC')->format('Ymd\THis\Z');
            $lines[] = 'DTSTART:'.$start->format('Ymd\THis\Z');
            $lines[] = 'DTEND:'.$end->format('Ymd\THis\Z');
            $lines[] = 'SUMMARY:'.$this->escape($summary);

            if ($client?->adresse) {
                $lines[] = 'LOCATION:'.$this->escape($client->adresse);
            }

            if ($rendezVous->notes) {
                $lines[] = 'DESCRIPTION:'.$this->escape($rendezVous->notes);
            }

            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines)."\r\n";
    }

    private function escape(string $value): string
    {
        return str_replace(["\\", ',', ';', "\n"], ['\\\\', '\,', '\;', '\n'], $value);
    }
}
