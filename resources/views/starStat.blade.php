<h1>STARS</h1>
<table>
    <thead>
    <th>id</th>
    <th>оценка</th>
    </thead>
    <tbody>
    @foreach ( $starts as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->assessment }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
