@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#testModal" style="width:8%" onclick="setAddModal()">
                    {{ __('追加') }}
                </button>            
            </div>
            
            <form method="GET" action="{{ url('/home') }}">
                <div class="form-group row justify-content-center">
                    <div class="col-xs-3">
                        <input type="date" class="form-control" id="calendar" name="calendar" value="{{ $calendar }}" onchange="this.form.submit()">       
                    </div>
                </div>
            </form>

            <div class="card mt-3">
                <div class="card-header">ToDo</div>
                <div class="card-body">
                    @isset($records[0])
                    <table class="table">
                        <tr class="thead-light">
                            <th class="align-middle" style="width: 10%"></th>
                            <th class="align-middle" style="width: 50%">作業</th>
                            <th class="align-middle" style="width: 10%">予定時間</th>
                            <th class="align-middle" style="width: 10%">完了時間</th>
                            <th class="align-middle" style="width: 10%"></th>
                            <th class="align-middle" style="width: 10%"></th>
                        </tr>
                        @each('subviews.todos', $records, 'record')
                    </table>
                    @else
                    データがありません
                    @endisset
                </div>
            </div>
            <form id="delete-form" method="POST" action="{{ url('/home/check') }}">
                <div class="text-left mt-2">
                    @csrf
                    <div class='btn-toolbar' role="toolbar">
                        <button type="submit" id="del-btn" name="del" class="btn btn-danger mr-2" style="display:none;width:8%">
                                {{ __('削除') }}
                        </button>
                        <button type="submit" id="fin-btn" name="fin" class="btn btn-success" style="display:none;width:8%">
                                {{ __('完了') }}
                        </button>      
                    </div>
                </div>
                <input type="hidden" name="calendar" value="{{ $calendar }}">
            </form>
        </div>
    </div>
</div>

<!-- タスク追加用モーダル -->
<div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="todoForm" method="POST" action="{{ url('/home') }}" onsubmit="return validation()">
                @csrf
                <input type="hidden" name="calendar" value="{{ $calendar }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">作業内容入力</h4>
                </div>
                <div class="modal-body">
                        <!-- 作業内容 -->
                        <div class="form-group col-7">
                            <label>作業内容：</label>
                            <input id="content" name="content" type="text" class="form-control form-control-sm" value="{{old('content')}}" oninput="inputChange(this)">
                            <p id="con_valid" class="validation"></p>
                        </div>

                        <!-- 予定日付 -->
                        <div class="form-group col-7">
                            <label for="datePicker" class="pt-1 pr-2">予定日時：</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="datetime" name="datetime" value="{{old('datetime')}}" oninput="inputChange(this)">
                            <p id="dt_valid" class="validation"></p>
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="deleteMsg()">閉じる</button>
                    <button type="submit" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- タスク修正用モーダル -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateForm" name="udForm" method="POST" action="{{ url('/home/update') }}" onsubmit="return update_validation()">
                @csrf
                <input type="hidden" name="calendar" value="{{ $calendar }}">
                <input type="hidden" id="todoId" name="todoId">
                <input type="hidden" id="col_key">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">修正</h4>
                </div>
                <div class="modal-body">
                    <!-- 作業内容 -->
                    <div class="form-group col-7">
                        <label>作業内容：</label>
                        <input id="ud_content" name="content" type="text" class="form-control form-control-sm" oninput="inputChange(this)">
                        <p id="ud_con_valid" class="validation"></p>
                    </div>

                    <!-- 予定日付 -->
                    <div id="pa_div" class="form-group col-7">
                        <label for="datePicker" class="pt-1 pr-2">予定日時：</label>
                        <input type="datetime-local" class="form-control form-control-sm" id="ud_pa" name="pa" oninput="inputChange(this)">
                        <p id="ud_pa_valid" class="validation"></p>
                    </div>

                    <!-- 完了日付 -->
                    <div id="fa_div" class="form-group col-7" style="display:none">
                        <label for="datePicker" class="pt-1 pr-2">完了日時：</label>
                        <input type="datetime-local" class="form-control form-control-sm" id="ud_fa" name="fa" oninput="inputChange(this)">
                        <p id="ud_fa_valid" class="validation"></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="deleteMsg()">閉じる</button>
                    <button id="ud_button" type="submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection