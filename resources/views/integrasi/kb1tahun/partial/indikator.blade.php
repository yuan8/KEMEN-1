
@php
$pni=$di['_indikator'];
  switch ((int)$parent['jenis']) {
    case -1:
      # code...
      $name='INDIKATOR_MAJOR';
      $parent_name='MAJOR';
      $child_name='PP';
      break;
    case 1:
      # code...
      $name='INDIKATOR_PN';
      $parent_name='PN';
      $child_name='PP';
      break;
    case 2:
      # code...
      $name='INDIKATOR_PP';
      $parent_name='PP';
      $child_name='KP';
      break;
    case 3:
      # code...
      $name='INDIKATOR_KP';
      $parent_name='KP';
      $child_name='KP';
      break;
    case 4:
      # code...
      $name='INDIKATOR_PROPN';
      $parent_name='PROPN';
      $child_name='PROPN';
      break;
    case 5:
      # code...
      $name='INDIKATOR_PROYEK';
      $parent_name='PROYEK';
      $child_name=null;
      break;
    
    default:
      # code...
      break;
  }
@endphp
<tr  {!! $parent_name?'data-tt-parent-id="'.$parent_name.'-'.$parent['id'].'"':'' !!}  data-tt-id="{{$name}}-{{$di['id']}}">
  <td>
    <div class="btn-group-bt-5 ">
      <button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$pni['id']}})">
        <i class="fa fa-eye">
          
        </i>
        {{(str_replace('_',' ',$name))}}
      </button>
      <button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$di['id']}},{{$pni['jenis']}})">
        <i class="fa fa-trash"> 
        </i>
        {{(str_replace('_',' ',$name))}}
      </button>
    </div>
  </td>
  <td class="bg-gray" >
  </td>
  <td>
   <p> <b>{{(str_replace('_',' ',$name))}} :
    </b> {{$pni['uraian']}}</p>
  </td>
  
  <td>
    @if(($pni['tipe_value']==1)OR($pni['tipe_value']==2))
    {{number_format($pni['target'],2)}}
    @else
    {{$pni['target']}}
    @endif
    @if($pni['tipe_value']==2)
    <-> {{number_format($pni['target_1'],2)}}
      @endif
  </td>
  <td>{{$pni['satuan']}}
  </td>
  <td>
    {!!$pni['lokus']!!}
  </td>
  <td>
    @php
    $i=$pni;
    $i['pelaksana_nas']=is_array($pni['pelaksana_nas'])?$pni['pelaksana_nas']:json_decode($pni['pelaksana_nas']??'[]');
    $i['pelaksana_p']=is_array($pni['pelaksana_p'])?$pni['pelaksana_p']:json_decode($pni['pelaksana_p']??'[]');
    $i['pelaksana_k']=is_array($pni['pelaksana_k'])?$pni['pelaksana_k']:json_decode($pni['pelaksana_k']??'[]');
    @endphp
    <b>PUSAT
    </b>
    <ul>
      @foreach($i['pelaksana_nas'] as $p)
      <li>{{$p}}
      </li>
      @endforeach
    </ul>
    <b>PROVINSI
    </b>
    <ul>
      @foreach($i['pelaksana_p'] as $p)
      <li>{{$p}}
      </li>
      @endforeach
    </ul>
    <b>KOTA/KAB
    </b>
    <ul>
      @foreach($i['pelaksana_k'] as $p)
      <li>{{$p}}
      </li>
      @endforeach
    </ul>
  </td>
</tr>