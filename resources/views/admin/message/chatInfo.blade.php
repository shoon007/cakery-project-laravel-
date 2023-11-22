@extends('admin.message.listPage')

@section('story')
    {{-- admin chat information --}}
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
    <div class="main">
        <a href="{{ route('admins#chat') }}">
            <button class="back-btn" style="margin:2.5rem 0rem 1rem 4rem">
                <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1"
                    viewBox="0 0 1024 1024">
                    <path
                        d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
                    </path>
                </svg>
                <span>Back</span>
            </button>
        </a>
        <div class="info-container">
            <h1 class="title">Admins Chat Information</h1>
            <div class="form">
                <div class="change-name">
                    <i class="fa-solid fa-pencil ms-3"></i>
                    <a href="#0" id="info" class="info popup-trigger">Change chat name</a>
                </div>

                <div class="popup" role="alert">
                    <div class="popup-container">
                        <a href="#0" class="popup-close img-replace">Close</a>
                        <h2>Change chat name</h2>
                        <hr>
                        <p class="fs-6">Changing the name of a group chat changes it for everyone.</p>
                        <form action="{{ route('save#titleChat') }}" method="post" id="form">
                            @csrf
                            <input type="text"
                                @if (count($groupName) > 0 && $groupName[0]->group_title !== null) value="{{ $groupName[0]->group_title }}"  @else value="Admins" @endif
                                name="chatTitle" id="groupTitle" maxlength="10">
                            <span id="charactersLeft" class="ms-2"> 0 </span> / <span id="length"> 10</span> <br>
                            <button id="saveBtn">Save</button> <br>

                        </form>
                    </div>
                </div>

                <form method="post" action="{{ route('chat#uploadImg') }}" enctype="multipart/form-data"
                    style="box-shadow: none;padding:0rem;width:100%">
                    @csrf

                    <div class="w-100">
                        {{--  <i class="fa-regular fa-image"></i>
            <span class="ms-3">Change photo</span> --}}
                        <input type="hidden" id="name">
                        <input type="file" id="realFile" hidden="hidden" onchange="this.form.submit()" name="chatImg" />
                        <button class="change-photo d-flex align-items-center" type="button" id="customBtn">
                            <i class="fa-regular fa-image ms-3 me-3"></i>
                            Change chat photo</button>
                    </div>

                </form>

                <div class="members d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-user-group ms-3"></i>
                    <a href="#0" id="info2" class="info2 popup-trigger2">Chat members</a>
                </div>
                <div class="popup2" role="alert">
                    <div class="popup-container2">
                        <a href="#0" class="popup-close2 img-replace2">Close</a>
                        <h2>Chat Members</h2>
                        <hr>
                        <div class="groups">
                            @foreach ($members as $member)
                                <div class="chatMember">
                                    @if ($member->image !== null)
                                        <img src="{{ asset('storage/' . $member->image) }}" alt="">
                                    @else
                                        <img src="{{ asset('img/default-male.png') }}" alt="">
                                    @endif
                                    <small>{{ $member->name }}</small>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>

            </div>

        </div>
    @endsection
    @section('chatInfo')
        <script src="{{ asset('js/admin/message/chatInfo.js') }}"></script>
    @endsection
