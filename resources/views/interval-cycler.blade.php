@extends('layout')

@section('content')
    <h1 class="text-center">Interval Cycler</h1>
    <p class="text-center">Enter pitches as space-separated integers or generate a random row.</p>

    <!-- Form -->
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="row" class="form-label">Pitch Row</label>
            <input type="text" class="form-control" id="row" name="row" placeholder="e.g., 0 4 7 11">
        </div>
        <button type="submit" name="action" value="process" class="btn btn-primary">Process Row</button>
        <button type="submit" name="action" value="random" class="btn btn-secondary">Generate Random Row</button>
    </form>

    <!-- Error -->
    @if ($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <!-- Random Row -->
    @if ($randomRowDisplay)
        <div class="alert alert-info">Random Row: {{ $randomRowDisplay }}</div>
    @endif

    <!-- Results -->
    @if ($results)
        <h3>Pitch Rows</h3>
        <ul class="list-group mb-4">
            @foreach ($results['pitchRows'] as $row)
                <li class="list-group-item">{{ implode(' ', $row) }}</li>
            @endforeach
        </ul>

        <h3>Chords</h3>
        <ul class="list-group">
            @foreach ($results['chords'] as $chordSet)
                <li class="list-group-item">
                    @foreach ($chordSet as $chord)
                        {{ implode(' ', $chord) }}<br>
                    @endforeach
                </li>
            @endforeach
        </ul>
    @endif
@endsection
