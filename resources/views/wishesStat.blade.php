<h1>Пожелания</h1>
<table>
    <thead>
    <th>id</th>
    <th>Пожелание</th>
    </thead>
    <tbody>
    @foreach ( $wishes as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->wiches }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

