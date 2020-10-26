<A HREF=/update>Update</A>
<table border=1>
  <tr>
  @foreach ($keys as $key)
    <td>{{$key}}</td>
  @endforeach

</tr>
@foreach ($gitstars as $gitstar)

<tr>
@foreach ($keys as $key)
  <td>
    @if ($key == 'id')
    <A HREF="/show/{{$gitstar->$key}}/">
    @endif
    {{$gitstar->$key}}
    @if ($key == 'id')
  </A>
   @endif
  </td>
@endforeach

</tr>

@endforeach
</table>
