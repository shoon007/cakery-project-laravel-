@extends('admin.message.listPage')
@section('story')
    {{-- customer chat page --}}
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
    <div class="main customer-contact" style="">
        <div class="category-lists">
            <div class="d-flex  align-items-center mb-3">
                <div class="customer-image">
                    @if ($customerInfo->image !== null)
                        <img src="{{ asset('storage/images/' . $customerInfo->image) }}" alt="">
                    @else
                        <img src="{{ asset('img/default-male.png') }}" alt="">
                    @endif
                </div>
                <div class="ms-3 d-flex flex-column justify-content-center">
                    <h4 class="name">{{ $customerInfo->name }} </h4>
                    <small class="email">{{ $customerInfo->email }} </small>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="customer-id">ID</th>
                        <th class="customer-name">NAME</th>
                        <th class="customer-email">EMAIL</th>
                        <th class="customer-phone">PHONE</th>
                        <th class="customer-address">ADDRESS</th>
                        <th>MESSAGE</th>
                        <th class="time">TIME</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerContact as $contact)
                        <tr>
                            <td class="customer-id">{{ $contact->id }} </td>
                            <td class="customer-name">{{ $contact->name }} </td>
                            <td class="customer-email">{{ $contact->email }} </td>
                            <td class="customer-phone">{{ $contact->phone }} </td>
                            <td class="customer-address">{{ $contact->address }} </td>
                            <td class="message"> {{ substr($contact->message, 0, 20) }}..... <br><a
                                    href="{{ route('customer#viewMessage', $contact->id) }}"
                                    onclick="window.location.reload(true)">See more</a></td>
                            <td class="time">
                                {{ $contact->created_at->diffForHumans() }}
                            </td>
                            <td>

                                <ul class="wrapper">
                                    <a href="mailto:{{ $contact->email }}">
                                        <li class="icon">
                                            <span class="tooltip">Reply</span>
                                            <span><i class="fa-solid pen fa-reply"></i></span>
                                        </li>
                                    </a>
                                    <a href="{{ route('customer#deleteMessage', $contact->id) }}">
                                        <li class="icon ">
                                            <span class="tooltip">Delete</span>
                                            <span> <i class="fa-solid fa-trash delete"></i></span>
                                        </li>
                                    </a>
                                </ul>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

        <div class="mt-4">
            {{ $customerContact->links() }}
        </div>
    </div>
@endsection
