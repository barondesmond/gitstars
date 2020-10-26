<A HREF=/>Return to Index</A>
<table border=1>
  <tr>
  @foreach ($gitstars as $gitstar)

  @foreach ($keys as $key)
    <tr><td>{{$key}}</td>
    <td>{{$gitstar->$key}}</td></tr>

  @endforeach
  @endforeach
</tr>
</table>
