<?php

namespace App\Services;

class IntervalCycler {
    private $scale = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];

    public function __construct() {
    }

    /**
     * Get the note corresponding to a pitch value.
     */
    public function note($x) {
        return $this->scale[$x % 12];
    }

    /**
     * Get the direction and octave shift between two pitches.
     */
    public function getDirection($y, $x) {
        $diff = abs($y - $x);
        $octave = floor($diff / 12);
        $o = $octave > 0 ? $octave . ' ' : ' ';
        if ($y > $x) return '^' . $o;
        elseif ($y < $x) return '_' . $o;
        return '';
    }

    /**
     * Generate a random row of 12 unique pitches.
     */
    public function generateRandomPitches() {
        $pitches = range(0, 11);
        shuffle($pitches);
        return $pitches;
    }

    /**
     * Process the given row of pitches and return pitch rows and chords.
     */
    public function process($row) {
        $n = count($row);
        $intervals = [];
        for ($i = 1; $i < $n; $i++) {
            $intervals[] = $row[$i] - $row[$i - 1];
        }

        $rows = array_fill(0, $n, []);
        for ($i = 0; $i < $n; $i++) {
            $rows[$i][] = $row[0];
            for ($j = 1; $j < $n; $j++) {
                $rows[$i][] = $rows[$i][$j - 1] + $intervals[($i + $j) % $n];
            }
        }

        $chords = [];
        for ($j = 0; $j < $n; $j++) {
            $baseChord = array_unique($rows[$j]);
            $chordsRow = [$baseChord];
            for ($i = 1; $i < $n; $i++) {
                $adjusted = [];
                foreach ($rows as $s) {
                    $adjusted[] = $s[$i] - $row[$j] + $row[0];
                }
                $chordsRow[] = array_unique($adjusted);
            }
            $chords[] = $chordsRow;
        }

        $rnotes = [];
        foreach ($rows as $i) {
            $rowNotes = [$this->note($i[0])];
            for ($j = 1; $j < $n; $j++) {
                $rowNotes[] = $this->getDirection($i[$j], $i[$j - 1]) . $this->note($i[$j]);
            }
            $rnotes[] = $rowNotes;
        }

        $cnotes = [];
        foreach ($chords as $x) {
            $chordNotes = [];
            foreach ($x as $y) {
                $chordNotes[] = array_map([$this, 'note'], $y);
            }
            $cnotes[] = $chordNotes;
        }

        return ['pitchRows' => $rnotes, 'chords' => $cnotes];
    }
}
