<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css"  href="{{asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.css')}}">
</head>
<body>
  <table class="table">
  <thead>
   {{--  <tr>
    <td>
    <div class="header-space">&nbsp;</div>
    </td></tr> --}}
    <tr>
      <th>KODE</th>
      <th>INDIKATOR</th>

    </tr>
  </thead>
  <tbody>
    @foreach($data as $d)
    <tr>
      <td>
        {{$d->kode}}
      </td>
       <td>
        {{$d->uraian}}
      </td>
  </tr>
  @endforeach
   @foreach($data as $d)
    <tr>
      <td>
        {{$d->kode}}
      </td>
       <td>
        {{$d->uraian}}
      </td>
  </tr>
  @endforeach
   @foreach($data as $d)
    <tr>
      <td>
        {{$d->kode}}
      </td>
       <td>
        {{$d->uraian}}
      </td>
  </tr>
  @endforeach
   @foreach($data as $d)
    <tr>
      <td>
        {{$d->kode}}
      </td>
       <td>
        {{$d->uraian}}
      </td>
  </tr>
  @endforeach
</tbody>
  <tfoot><tr><td>
    <div class="footer-space">&nbsp;</div>
  </td></tr></tfoot>
</table>
<div class="header">...</div>
<div class="footer">...</div>


<style type="text/css">
.header, .header-space,
.footer, .footer-space {
  height: 100px;
}
.header {
  position: fixed;
  top: 0;
}
.footer {
  position: fixed;
  bottom: 0;
}
table td th{
  border: 1px solid #000;
}

</style>

</body>
</html>