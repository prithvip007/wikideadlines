<?php
namespace App\Services;

use DateTime;

class ICS
{
    protected $title = '';

    protected $dateFormat = '';

    protected $properties = [];

    protected $events = [];

    private $availableProperties = ['description', 'dtend', 'dtstart', 'location', 'summary', 'url'];

    public function __construct(array $events, $title = '', string $dateFormat = 'Ymd\THis\Z')
    {
        $this->dateFormat = $dateFormat;
        $this->title = $title;
        $this->set($events);
    }

    public function set($events)
    {
        foreach ($events as $item)
        {
            foreach ($item as $key => $value)
            {
                if (in_array($key, $this->availableProperties))
                {
                    $item[$key] = $this->sanitizeValue($value, $key);
                }
            }

            $this->events[] = $item;
        }
    }

    public function toString()
    {
        $rows = $this->buildProps();
        return implode("\r\n", $rows);
    }

    private function buildProps()
    {
        // Build ICS properties - add header
        $icsProps = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//hacksw/handcal//NONSGML v1.0//EN',
            'CALSCALE:GREGORIAN',
            'X-WR-CALNAME:' . $this->sanitizeValue($this->title)
        ];

        foreach ($this->events as $item)
        {
            $icsProps[] = 'BEGIN:VEVENT';

            // Build ICS properties - add header
            $props = [];
            foreach ($item as $k => $v)
            {
                $props[strtoupper($k . ($k === 'url' ? ';VALUE=URI' : '')) ] = $v;
            }

            // Set some default values
            $props['DTSTAMP'] = $this->formatTimestamp('now');
            $props['UID'] = uniqid();

            // Append properties
            foreach ($props as $k => $v)
            {
                $icsProps[] = "$k:$v";
            }

            $icsProps[] = 'END:VEVENT';
        }

        $icsProps[] = 'END:VCALENDAR';

        return $icsProps;
    }

    private function sanitizeValue($val, $key = false)
    {
        switch ($key)
        {
            case 'dtend':
            case 'dtstamp':
            case 'dtstart':
                $val = $this->formatTimestamp($val);
            break;
            default:
                $val = $this->escapeString($val);
        }

        return $val;
    }

    private function formatTimestamp($timestamp)
    {
        $dt = new DateTime($timestamp);
        return $dt->format($this->dateFormat);
    }

    private function escapeString($str)
    {
        return preg_replace('/([\,;])/', '\\\$1', $str);
    }
}
