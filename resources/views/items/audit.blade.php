@extends('items._layout')

@section('item-data')
        <table class="table table-striped table-condensed table-bordered">
            <thead>
                <tr>
                    <th>##</th>
                    <th>Event</th>
                    <th>User</th>
                    <th>Old Data</th>
                    <th>New Data</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($audits as $index => $audit)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $audit->event }}</td>
                        <td>{{ $audit->getMetadata()['user_name'] }}</td>
                        <td>
                            <ul>
                                @foreach($audit->getModified() as $property => $modified)
                                    <li style="list-style: none">{{ $property }} -  {{ $modified['old'] ?? 'null' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($audit->getModified() as $property => $modified)
                                    <li style="list-style: none">{{ $property }} - {{ $modified['new'] ?? 'null' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $audit->created_at->toFormattedDateString() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection