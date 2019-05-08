<h1>Пользователи зарегистрировавшиеся в боте</h1>
<table>
    <thead>
        <th>Id</th>
        <th>Имя</th>
        <th>Номер телефона</th>
    </thead>
    <tbody>
        @foreach ( $users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user->phone }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
