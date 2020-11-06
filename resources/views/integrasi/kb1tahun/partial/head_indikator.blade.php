 @php
  switch ((int)$d['jenis']) {
      case -1:
      # code...
      $name='MAJOR';
      $parent_name=null;
      $child_name='PP';
      break;
    case 1:
      # code...
      $name='PN';
      $parent_name=null;
      $child_name='PP';
      break;
    case 2:
      # code...
      $name='PP';
      $parent_name='PN';
      $child_name='KP';
      break;
     case 3:
      # code...
      $name='KP';
      $parent_name='PP';
      $child_name='KP';
      break;
     case 4:
      # code...
      $name='PROPN';
      $parent_name='KP';
      $child_name='PROYEK';
      break;
     case 5:
      # code...
      $name='PROYEK';
      $parent_name='PROPN';
      $child_name=null;


      break;
    
    default:
      # code...
      break;
  }
 @endphp
 <tr  {!! $parent_name?'data-tt-parent-id="'.$parent_name.'-'.$parent['id'].'"':'' !!}  data-tt-id="{{$name}}-{{$d['id']}}">
    <td>
      <div class="btn-group-bt-5">
        
            @if(($d['jenis']!=-1) and ($d['jenis']!=5))
              <button class="btn btn-primary  btn-xs" onclick="showFormNested({{$d['id']}},{{$d['jenis']}})" >
            <i  data-toggle="tooltip" data-placement="top" title="TAMBAH {{$child_name}}" class="fa fa-plus"></i> {{$child_name}}</button>

          @endif
          
            <button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$d['id']}},{{$d['jenis']}})"><i data-toggle="tooltip" data-placement="top" title="DELETE {{$name}}"  class="fa fa-trash"></i> {{$name}}</button>

          @if(($pn['jenis']==-1) or ($d['jenis']!=1))
          <button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$d['id']}},{{$d['jenis']}})" >
            <i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR {{$name}}" class="fa fa-plus"> </i> INDIKATOR {{$name}}

          </button>

          @endif
          </div>
      </div>
    </td>
   
    <td>
        @php
        for($i=0;$i<($d['jenis']==-1?1:$d['jenis']);$i++){
          @endphp
          {{-- <img src="{{asset('component-list/tree_lv2.png')}}"> --}}
      @php
      }
    @endphp

      <b>{{$name}}:
      </b> {{$d['uraian']}}
    </td>
    <td class="bg-navy">
      <b>URAIAN
      </b>
    </td>
    <td class="bg-navy">
      <b>TARGET
      </b>
    </td>
    <td class="bg-navy">
      <b>SATUAN
      </b>
    </td>
    <td class="bg-navy">
      <b>LOKUS
      </b>
    </td>
    <td class="bg-navy">
      <b>PELAKSANA
      </b>
    </td>
  </tr>