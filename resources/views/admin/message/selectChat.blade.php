@extends('admin.message.listPage')
@section('story')
    {{-- select chat page --}}
    <a href="{{ route('admins#chat') }}">
        <div class="story-circle">
            @if (count($groupName) > 0 && $groupName[0]->chat_img !== null)
                <img src="{{ asset('storage/' . $groupName[0]->chat_img) }}" alt="">
            @else
                <img src="{{ asset('img/default-group.png') }}" alt="">
            @endif
            @if (count($message) > 0)
                <span>{{ count($message) }} </span>
            @endif
            @if (count($groupName) > 0 && $groupName[0]->group_title !== null)
                <small class="d-flex flex-nowrap">{{ explode(' ', trim($groupName[0]->group_title))[0] }} </small>
            @else
                <small>admins</small>
            @endif
        </div>
    </a>
    @foreach ($customerMessage as $customer)
        <a href="{{ route('customer#contact', $customer->user_id) }}">
            <div class="story-circle">
                @if ($customer->image !== null)
                    <img src="{{ asset('storage/images/' . $customer->image) }}" alt="">
                @else
                    <img src="{{ asset('img/default-male.png') }}" alt="">
                @endif
                @foreach ($countMessage as $count)
                    @if ($customer->user_id === $count->user_id)
                        <span>{{ $count->count }} </span>
                    @endif
                @endforeach
                <small>{{ $customer->name }} </small>
            </div>
        </a>
    @endforeach
@endsection
@section('chats')
    <h1 class="select-chat">
        Select a chat or start a new conversation!
        <i class="fa-regular fa-hand-pointer ms-2 emoji"></i>
    </h1>
@endsection
