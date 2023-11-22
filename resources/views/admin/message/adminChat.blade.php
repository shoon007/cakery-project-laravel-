@extends('admin.message.listPage')
@section('story')
    {{-- admin chat page --}}
    <a href="{{ route('admins#chat') }}">
        <div class="story-circle">
            @if (count($groupName) > 0 && $groupName[0]->chat_img !== null)
                <img src="{{ asset('storage/' . $groupName[0]->chat_img) }}" alt="">
            @else
                <img src="{{ asset('img/default-group.png') }}" alt="">
            @endif

            @if (count($groupName) > 0 && $groupName[0]->group_title !== null)
                <small> {{ explode(' ', trim($groupName[0]->group_title))[0] }}</small>
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

    <div class="message-box">
        <div class="nav-title">
            <div class="nav">
                <a href="{{ route('info#chat') }}">
                    <div class="d-flex">
                        @if (count($groupName) > 0 && $groupName[0]->chat_img !== null)
                            <img src="{{ asset('storage/' . $groupName[0]->chat_img) }}" alt="">
                        @else
                            <img src="{{ asset('img/default-group.png') }}" alt="">
                        @endif
                        @if (count($groupName) > 0)
                            <h3> {{ $groupName[0]->group_title }}</h3>
                        @else
                            <h3>Admins</h3>
                        @endif
                    </div>
                </a>
                <i class="fa-solid fa-ellipsis-vertical setting"></i>
            </div>
            <div class="chat-setting" style="display: none">
                <i class="fa-solid fa-caret-up triangle"></i>
                <ul>
                    <a href="{{ route('info#chat') }}">
                        <li class='line'>
                            <i class="fa-solid fa-circle-info"></i>
                            <span>
                                Chat Info
                            </span>
                        </li>
                    </a>
                    <a href="{{ route('select#chat') }}">
                        <li class='line'>
                            <i class="fa-regular fa-circle-xmark "></i>
                            <span>
                                Close chat
                            </span>
                        </li>
                    </a>
                    <a href="{{ route('delete#chat', Auth::user()->id) }}">
                        <li>
                            <i class="fa-solid fa-trash"></i>
                            <span>
                                Delete chat
                            </span>
                        </li>
                    </a>
                </ul>
            </div>
        </div>

        <div class="main-message" id="element">

            @if (count($datas) > 0)
                @php
                    $previousDate = null;
                @endphp
                @foreach ($datas as $data)
                    @if ($data->user_id === Auth::user()->id)
                        @if ($loop->first || $data->created_at->format('d M,Y') != $previousDate)
                            <p class="text-center mt-3">{{ $data->created_at->format('M d, Y, h:i A') }}
                            </p>
                        @endif

                        @php
                            $previousDate = $data->created_at->format('d M,Y');
                        @endphp
                        <div class="message-reply">
                            @if ($data['image'] !== null)
                                <div class="reply-image ">
                                    <a href="{{ route('image#delete', $data->id) }}" id="deleteImg-{{ $data->id }}"
                                        style="display:none">
                                        <span class="">
                                            <i class="fa-regular fa-circle-xmark hideText"></i>
                                        </span>
                                    </a>
                                    <img src="{{ asset('storage/' . $data->image) }}" alt=""
                                        onclick="toggleImgDelete({{ $data->id }})">
                                </div>
                                <small>{{ $data->created_at->format('h:i A') }}</small>
                            @endif
                            @if ($data['message'] !== null)
                                <div class="reply">
                                    <a href="{{ route('message#delete', $data->id) }}" id="delete-{{ $data->id }}"
                                        style="display:none">
                                        <span>
                                            <i class="fa-regular fa-circle-xmark "></i>
                                        </span>
                                    </a>
                                    <div class="text-box " onclick="toggleDelete({{ $data->id }})">
                                        {{ $data->message }}
                                    </div>
                                </div>
                                <small>{{ $data->created_at->format('h:i A') }}</small>
                            @endif

                        </div>
                    @else
                        @if ($loop->first || $data->created_at->format('d M,Y') != $previousDate)
                            <p class="text-center mt-3">{{ $data->created_at->format('M d, Y, h:i A') }}
                            </p>
                        @endif

                        @php
                            $previousDate = $data->created_at->format('d M,Y');
                        @endphp
                        <div class="message">
                            <div
                                class="d-flex flex-column justify-content-center align-items-center text-secondary img-container">
                                @if ($data->user_name !== null)
                                    <small class="mb-1">
                                        {{ explode(' ', trim($data->user_name))[0] }}
                                    </small>
                                    @if ($data->user_image !== null)
                                        <img src="{{ asset('storage/' . $data->user_image) }}" alt="">
                                    @else
                                        <img src="{{ asset('img/default-male.png') }}" alt="">
                                    @endif
                                @else
                                    <img src="{{ asset('img/cancel_user.png') }}" alt="">
                                @endif

                            </div>
                            <div class="boxes">
                                @if ($data->image !== null)
                                    <div>
                                        <div class="img-box">
                                            <img src="{{ asset('storage/' . $data->image) }}" alt="">
                                        </div>
                                        <small>{{ $data->created_at->format('h:i A') }}</small>
                                    </div>
                                @endif

                                @if ($data->message !== null)
                                    <div class="text-box">
                                        {{ $data->message }}
                                    </div>
                                    <small>{{ $data->created_at->format('h:i A') }}</small>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <h1 class="default-text">Send a message here
                    <i class="fa-regular fa-paper-plane  ms-2 emoji"></i>
                </h1>
            @endif

        </div>

        <div class="input-box">
            <form id="form" action="{{ route('message#reply') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                <div class="preview">
                    <img id="preview-img" src="" alt="">
                    <i class="fa-regular fa-circle-xmark" id="preview-delete"></i>
                </div>

                <div class="d-flex justify-content-center align-items-center">

                    <input id="inputBox" class="emojionearea-picker" type="text" name="message"
                        placeholder="Write a message here..." autofocus>

                    <div class="file-upload">
                        <input class="file-upload__input" type="file" name="image" id="myFile" multiple
                            onchange="document.getElementById('preview-img').src = window.URL.createObjectURL(this.files[0])">

                        <button class="file-upload__button" type="button">
                            <i class="fa-regular fa-image"></i>
                        </button>
                        <span class="file-upload__label d-none">
                    </div>
                    <button type="submit" id="sendBtn">
                        <i class="fa-regular fa-paper-plane"></i>
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('list')
    <script src="{{ asset('js/admin/message/list.js') }}"></script>
@endsection
