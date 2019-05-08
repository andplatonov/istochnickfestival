<h1>Вопросы от пользователей</h1>
<table>
    <thead>
        <th>id</th>
        <th>Вопрос</th>
    </thead>
    <tbody>
    @foreach ( $keppQuestion as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->question }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
