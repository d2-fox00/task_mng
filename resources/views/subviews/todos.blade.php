<tr class="@isset($record->finished_at) table-success @endisset">
    <!-- チェックボックス -->
    <td class="align-middle">
        <div class="custom-control custom-checkbox">
            <input type="checkbox"  name="checks[]" class="del-check big" form="delete-form" value="{{ $record->id }}" onchange="changeDelete()">
        </div>
    </td>
    <!-- 作業内容 -->
    <td id="content_{{ $key }}" class="align-middle">{{ $record->content }}</td>
    <!-- 予定時刻 -->
    <td class="align-middle">
        <div id="pa_{{ $key }}" class="text-center">
            {{ $record->planed_at->format('H:i') }}
        </div>
    </td>
    <!-- 終了時刻 -->
    <td class="align-middle">
        <div id="fa_{{ $key }}" class="fa text-center">
            @isset($record->finished_at)
            {{ $record->finished_at->format('H:i') }}
            @else
            -
            @endisset
        </div>
    </td>
    <!-- 完了ボタン -->
    <td class="align-middle">
        <div class="text-center">
            @if(empty($record->finished_at) && $record->planed_at->format('Y-m-d') == date('Y-m-d'))
            <form method="POST" action="{{ url('/home/finish') }}">
                @csrf
                <button type="submit" class="btn btn-success">
                        {{ __('完了') }}
                </button>
                <input type="hidden" name="id" value="{{ $record->id }}">
            </form>
            @endempty        
        </div>
    </td>
    <!-- 修正ボタン -->
    <td class="align-middle">
        <div class="text-center">
            <button id="update_{{ $key }}" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#updateModal" onclick="setUpdateModal(this)">
                    {{ __('修正') }}
            </button>
            <input type="hidden" name="id" id="id_{{ $key }}" value="{{ $record->id }}"> 
        </div>
    </td>
</tr>

