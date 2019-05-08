<h1>Сказали "Да"</h1>
<table>
    <thead>
    <th>id</th>
    <th>Вопрос</th>
    </thead>
    <tbody>
    @foreach ( $visitor as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->chat_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
