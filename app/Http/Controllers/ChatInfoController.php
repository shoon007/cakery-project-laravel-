<?php

namespace App\Http\Controllers;

use App\Models\ChatInfo;
use App\Models\CustomerContact;
use App\Models\MessageStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChatInfoController extends Controller
{
//CHAT INFORMATION
    public function infoChat()
    {
        $groupName = ChatInfo::get();
        $members = User::get();

        $customerMessage = CustomerContact::select('customer_contacts.*', 'customers.image as image')
            ->leftJoin('customers', 'customers.id', '=', 'customer_contacts.user_id')
            ->whereIn('customer_contacts.id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('customer_contacts')
                    ->groupBy('user_id');
            })
            ->orderBy('customer_contacts.id', 'desc')
            ->get();

        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();

        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.message.chatInfo', compact('groupName', 'members', 'customerMessage', 'countMessage', 'message'));
    }

//SAVING CHAT TITLE
    public function saveTitle(Request $request)
    {
        if ($request->chatTitle !== "") {
            $chatInfo = ChatInfo::get();
            //  dd($chatInfo->toArray());
            if (count($chatInfo) == 0) {
                ChatInfo::create([
                    'group_title' => $request->chatTitle,
                ]);
            } else {
                ChatInfo::where('id', 1)->update([
                    'group_title' => $request->chatTitle,
                ]);
            }

        }
        return back();
    }

//CHANGING GROUP TITLE
    public function uploadImg(Request $request)
    {
        if ($request->hasFile('chatImg')) {

            //create unique img name
            $fileName = uniqid() . $request->file('chatImg')->getClientOriginalName();
            // img saving in public file & database
            $request->file('chatImg')->storeAs('public/' . $fileName);

            $chatImg = ChatInfo::get();

            if (count($chatImg) == 0) {
                ChatInfo::create([
                    'chat_img' => $fileName,
                ]);
            } else {

                ChatInfo::where('id', 1)->update([
                    'chat_img' => $fileName,
                ]);

                if ($chatImg[0]->chat_img != null) {
                    Storage::delete('public/' . $chatImg[0]->chat_img);
                }
            }
            return back();
        }
    }

}
