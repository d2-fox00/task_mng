@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('アカウント削除') }}</div>

                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">
                        {{ __('アカウントを削除する') }}
                    </button>  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 確認メッセージ -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">確認画面</h4>
            </div>
            <div class="modal-body">
                アカウントを削除しますか?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                <a class="btn btn-danger" href="{{ url('/setting/delete') }}">削除</a>
            </div>
        </div>
    </div>
</div>
@endsection