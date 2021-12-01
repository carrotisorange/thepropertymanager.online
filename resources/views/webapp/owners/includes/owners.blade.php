<tr>
    <th><a href="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}">{{ $owner->name }} </a>
    </th>
    <td>{{ $owner->email}}</td>
    <td>{{ $owner->mobile }}</td>
    <td>{{ $owner->address }}</td>
    <td>{{ $owner->representative }}</td>
</tr>